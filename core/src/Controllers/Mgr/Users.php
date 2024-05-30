<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Database\Models\User;
use MMX\Database\Models\UserProfile;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class Users extends ModelController
{
    protected string $model = User::class;

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

        return $this->addJoin($c);
    }

    protected function afterCount(Builder $c): Builder
    {
        $c->with('Group');
        $c->with('Members', 'Members.Group');

        return $c;
    }

    protected function beforeSave(Model $record): ?ResponseInterface
    {
        /** @var User $record */
        if ($record->newQuery()->where('username', $record->username)->where('id', '!=', $record->id)->exists()) {
            return $this->failure('errors.user.username_unique');
        }

        return null;
    }

    protected function afterSave(Model $record): Model
    {
        /** @var User $record */
        if (!$profile = $record->Profile) {
            $profile = new UserProfile();
            $profile->internalKey = $record->id;
            $profile->address = '';
            $profile->comment = '';
        }
        $profile->fill($this->getProperties());
        $profile->save();

        return $record;
    }

    protected function addJoin(Builder $c): Builder
    {
        $c->join('user_attributes', 'users.id', '=', 'user_attributes.internalKey');
        $c->select('user_attributes.*');
        $c->addSelect('users.*');

        return $c;
    }
}