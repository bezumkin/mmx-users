<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use MMX\Database\Models\UserGroupRole;
use Vesp\Controllers\ModelGetController;

class UserGroupRoles extends ModelGetController
{
    protected string $model = UserGroupRole::class;

    protected function beforeCount(Builder $c): Builder
    {
        if ($query = trim($this->getProperty('query', ''))) {
            $c->where(static function (Builder $c) use ($query) {
                $c->where('name', 'LIKE', "%$query%");
                $c->orWhere('description', 'LIKE', "%$query%");
            });
        }

        return $c;
    }
}