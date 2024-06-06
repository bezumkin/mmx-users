<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use Vesp\Controllers\ModelGetController;

class Namespaces extends ModelGetController
{
    protected string $model = \MMX\Database\Models\Namespaces::class;
    protected string|array $primaryKey = 'name';

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = $this->getProperty('query')) {
            $c->where('name', 'LIKE', "%$query%");
        }

        return $c;
    }

    protected function afterCount(Builder $c): Builder
    {
        if ($this->getProperty('combo')) {
            $c->select('name');
        }

        return $c;
    }
}