<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use MMX\Database\Models\User;
use MMX\Database\Models\UserSetting;
use MMX\Users\App;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\ProcessorResponse;
use MODX\Revolution\Processors\Security\User\Create;
use MODX\Revolution\Processors\Security\User\Delete;
use MODX\Revolution\Processors\Security\User\Update;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Users extends ModelController
{
    protected string $model = User::class;
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    protected function beforeGet(Builder $c): Builder
    {
        return $this->addJoin($c);
    }

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = trim($this->getProperty('query', ''))) {
            $c->where(static function (Builder $c) use ($query) {
                $c->where('username', 'LIKE', "%$query%");
                $c->orWhere('fullname', 'LIKE', "%$query%");
                $c->orWhere('email', 'LIKE', "%$query%");
            });
        }

        $status = $this->getProperty('status');
        if ($status !== null) {
            $c->where('active', !empty($status));
        }

        if ($group = $this->getProperty('group')) {
            $c->whereHas('Members', static function (Builder $c) use ($group) {
                $c->where('user_group', $group);
            });
        }

        return $this->addJoin($c);
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('Group');
        $c->with('Members', 'Members.Group');

        return $c;
    }

    protected function addSorting(Builder $c): Builder
    {
        $dir = $this->getProperty('dir', 'asc');
        if ($sort = $this->getProperty('sort')) {
            if ($sort === 'id') {
                $c->orderBy('users.id', $dir);
            } elseif (str_starts_with($sort, 'settings.')) {
                $column = substr($sort, 9);
                $c->leftJoin('user_settings', static function (JoinClause $join) use ($column) {
                    $join->on('users.id', '=', 'user_settings.user');
                    $join->where('key', $column);
                });
                $c->orderBy('user_settings.value', $dir);
            }
        }

        return $c;
    }

    protected function addJoin(Builder $c): Builder
    {
        $c->join('user_attributes', 'users.id', '=', 'user_attributes.internalKey');
        $c->select('user_attributes.*');
        $c->addSelect('users.*');

        $c->with('Settings:user,key,value,xtype');

        return $c;
    }

    public function prepareRow(Model $object): array
    {
        $array = $object->toArray();
        $array['extended'] = json_decode($array['extended'] ?? '[]', true);
        if (!empty($array['dob'])) {
            $array['dob'] = date('Y-m-d', $array['dob']);
        }

        if (!empty($array['settings'])) {
            if ($this->getPrimaryKey()) {
                $array['settings'] = array_map(static function ($setting) {
                    if ($setting['xtype'] === 'combo-boolean') {
                        $setting['value'] = (bool)$setting['value'];
                    }

                    return $setting;
                }, $array['settings']);
            } else {
                $settings = [];
                foreach ($array['settings'] as $setting) {
                    $settings[$setting['key']] = $setting['value'];
                }
                $array['settings'] = $settings;
            }
        }

        return $array;
    }

    public function put(): ResponseInterface
    {
        $properties = $this->getProperties();
        $properties['passwordnotifymethod'] = 's';
        $properties['passwordgenmethod'] = empty($properties['specifiedpassword']) ? 'g' : 's';
        if (!empty($properties['groups'])) {
            $properties['groups'] = array_map(static function ($group) {
                $group['usergroup'] = $group['user_group'];
                unset($group['user_group']);

                return $group;
            }, $properties['groups']);
        }

        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Create::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }
        $this->setSettings($response->getObject()['id']);

        return $this->success(strip_tags($response->getMessage()));
    }

    public function patch(): ResponseInterface
    {
        $properties = $this->getProperties();
        if ($properties['newpassword'] = empty($properties['specifiedpassword']) ? null : true) {
            $properties['passwordnotifymethod'] = 's';
            $properties['passwordgenmethod'] = 's';
        }

        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Update::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }
        $this->setSettings($response->getObject()['id']);

        return $this->success(strip_tags($response->getMessage()));
    }

    public function delete(): ResponseInterface
    {
        $properties = $this->getProperties();
        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Delete::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success();
    }

    protected function setSettings(int $id): bool
    {
        /** @var User $user */
        if (!$user = User::query()->find($id)) {
            return false;
        }
        $settings = $this->getProperty('settings', []);

        foreach ($settings as $data) {
            $pk = ['user' => $user->id, 'key' => $data['key']];
            if (!$setting = $user->Settings()->where($pk)->first()) {
                $setting = new UserSetting();
                $setting->forceFill($pk);
            }
            $setting->xtype = $data['xtype'] ?? 'textfield';
            $setting->value = $data['value'];
            $setting->save();
        }

        return true;
    }
}