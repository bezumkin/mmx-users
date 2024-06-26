<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\UserGroup;
use MMX\Users\App;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\ProcessorResponse;
use MODX\Revolution\Processors\Security\Group\Create;
use MODX\Revolution\Processors\Security\Group\Remove;
use MODX\Revolution\Processors\Security\Group\Update;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class UserGroups extends ModelController
{
    protected string $model = UserGroup::class;
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = trim($this->getProperty('query', ''))) {
            $c->where(static function (Builder $c) use ($query) {
                $c->where('name', 'LIKE', "%$query%");
                $c->orWhere('description', 'LIKE', "%$query%");
            });
        }
        if ($exclude = $this->getProperty('exclude')) {
            $c->where('id', '!=', $exclude);
        }

        return $c;
    }

    protected function afterCount(Builder $c): Builder
    {
        if ($this->getProperty('combo')) {
            $c->select('id', 'name');
        } else {
            $c->with('Parent');
            $c->withCount('Members');
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

        return $this->success();
    }

    public function patch(): ResponseInterface
    {
        $properties = $this->getProperties();
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