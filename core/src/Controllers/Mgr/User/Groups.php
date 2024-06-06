<?php

namespace MMX\Users\Controllers\Mgr\User;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\UserGroupMember;
use MMX\Users\App;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\ProcessorResponse;
use MODX\Revolution\Processors\Security\Group\User\Create;
use MODX\Revolution\Processors\Security\Group\User\Remove;
use MODX\Revolution\Processors\Security\Group\User\Update;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Groups extends ModelController
{
    protected string $model = UserGroupMember::class;
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    protected function beforeGet(Builder $c): Builder
    {
        $c->where('member', $this->getProperty('user'));

        return $c;
    }

    protected function beforeCount(Builder $c): Builder
    {
        $c->where('member', $this->getProperty('user'));

        if ($query = $this->getProperty('query')) {
            $c->whereHas('Group', static function (Builder $c) use ($query) {
                $c->where('name', 'LIKE', "%$query%");
                $c->orWhere('description', 'LIKE', "%$query%");
            });
        }

        return $c;
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('Group:id,name');
        $c->with('Role:id,name');

        return $c;
    }

    public function put(): ResponseInterface
    {
        $properties = $this->getProperties();
        $properties['usergroup'] = $properties['user_group'];
        $properties['user'] = $properties['member'];
        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Create::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success();
    }

    public function patch(): ResponseInterface
    {
        $properties = $this->getProperties();
        $properties['usergroup'] = $properties['user_group'];
        $properties['user'] = $properties['member'];
        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Update::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success();
    }

    public function delete(): ResponseInterface
    {
        /** @var UserGroupMember $membershop */
        if (!$membershop = UserGroupMember::query()->find($this->getProperty('id'))) {
            return $this->failure('Could not find a record', 404);
        }
        $properties = ['usergroup' => $membershop->user_group, 'user' => $membershop->member];

        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Remove::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success();
    }
}