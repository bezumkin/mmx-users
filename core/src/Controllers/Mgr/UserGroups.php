<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Database\Models\UserGroup;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class UserGroups extends ModelController
{
    protected string $model = UserGroup::class;

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
        $c->with('Parent');

        return $c;
    }

    protected function beforeSave(Model $record): ?ResponseInterface
    {
        /** @var UserGroup $record */
        if ($record->newQuery()->where('name', $record->name)->where('id', '!=', $record->id)->exists()) {
            return $this->failure('errors.user_group.name_unique');
        }

        return null;
    }
}