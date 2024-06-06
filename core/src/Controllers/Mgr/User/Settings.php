<?php

namespace MMX\Users\Controllers\Mgr\User;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\UserSetting;
use MMX\Users\App;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\ProcessorResponse;
use MODX\Revolution\Processors\Security\User\Setting\Create;
use MODX\Revolution\Processors\Security\User\Setting\Remove;
use MODX\Revolution\Processors\Security\User\Setting\Update;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Settings extends ModelController
{
    protected string $model = UserSetting::class;
    protected string|array $primaryKey = ['user', 'key'];
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    protected function beforeGet(Builder $c): Builder
    {
        $c->where('user', $this->getProperty('user'));

        return $c;
    }

    protected function beforeCount(Builder $c): Builder
    {
        $c->where('user', $this->getProperty('user'));

        if ($query = $this->getProperty('query')) {
            $c->where(static function(Builder $c) use ($query) {
                $c->where('key', 'LIKE', "%$query%");
                $c->orWhere('value', 'LIKE', "%$query%");
                $c->orWhere('namespace', 'LIKE', "%$query%");
                $c->orWhere('area', 'LIKE', "%$query%");
            });
        }

        return $c;
    }

    public function put(): ResponseInterface
    {
        $properties = $this->getProperties();
        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Create::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success($response->getObject());
    }

    public function patch(): ResponseInterface
    {
        $properties = $this->getProperties();
        $properties['fk'] = $properties['user'];
        /** @var ProcessorResponse $response */
        $response = $this->modx->runProcessor(Update::class, $properties);
        if ($response->isError()) {
            $message = App::getErrorMessage($response);
            $this->modx->log(modX::LOG_LEVEL_ERROR, $message . print_r($properties, true));

            return $this->failure($message);
        }

        return $this->success($response->getObject());
    }

    public function delete(): ResponseInterface
    {
        $properties = $this->getProperties();
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