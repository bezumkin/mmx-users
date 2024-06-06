<?php

namespace MMX\Users\Controllers\Mgr\UserGroup;

use Illuminate\Database\Eloquent\Builder;
use MMX\Users\Controllers\Mgr\User\Groups;

class Users extends Groups
{
    protected function beforeGet(Builder $c): Builder
    {
        $c->where('user_group', $this->getProperty('group'));

        return $c;
    }

    protected function beforeCount(Builder $c): Builder
    {
        $c->where('user_group', $this->getProperty('group'));

        if ($query = $this->getProperty('query')) {
            $c->whereHas('User', static function (Builder $c) use ($query) {
                $c->where('username', 'LIKE', "%$query%");
                $c->orWhereHas('Profile', static function (Builder $c) use ($query) {
                    $c->where('fullname', 'LIKE', "%$query%");
                    $c->orWhere('email', 'LIKE', "%$query%");
                });
            });
        }

        return $c;
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('User:id,username');
        $c->with('Role:id,name');

        return $c;
    }
}