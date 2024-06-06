<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\Context;
use Vesp\Controllers\ModelGetController;

class Contexts extends ModelGetController
{
    protected string $model = Context::class;
    protected string|array $primaryKey = 'key';

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = $this->getProperty('query')) {
            $c->where('key', 'LIKE', "%$query%");
            $c->orWhere('name', 'LIKE', "%$query%");
        }

        return $c;
    }

    protected function afterCount(Builder $c): Builder
    {
        if ($this->getProperty('combo')) {
            $c->select('key', 'name');
        }

        return $c;
    }
}