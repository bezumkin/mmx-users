<?php

namespace MMX\Users\Controllers\Mgr\User;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use MMX\Users\Models\Commerce\Address;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\System\Country\GetList;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\ModelController;

class CommerceAddresses extends ModelController
{
    protected string $model = Address::class;
    protected modX $modx;
    protected array $countries = [];

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    public function get(): ResponseInterface
    {
        $processor = new GetList($this->modx, $this->getProperties());
        $this->countries = $processor->getCountryList();

        return parent::get();
    }

    protected function beforeGet(Builder $c): Builder
    {
        $c->where('user', $this->getProperty('user'));

        return $c;
    }

    protected function beforeCount(Builder $c): Builder
    {
        $c->where('user', $this->getProperty('user'));
        if ($type = $this->getProperty('type')) {
            $c->where('type', $type);
        }
        if ($query = $this->getProperty('query')) {
            $c->where(static function (Builder $c) use ($query) {
                $c->where('fullname', 'LIKE', "%$query%");
                $c->orWhere('company', 'LIKE', "%$query%");
                $c->orWhere('address1', 'LIKE', "%$query%");
                $c->orWhere('address2', 'LIKE', "%$query%");
                $c->orWhere('address3', 'LIKE', "%$query%");
                $c->orWhere('city', 'LIKE', "%$query%");
                $c->orWhere('email', 'LIKE', "%$query%");
            });
        }

        return $c;
    }

    public function prepareRow(Model $object): array
    {
        $array = $object->toArray();
        if (!$this->getPrimaryKey()) {
            if (!empty($array['country']) && $country = $this->countries[strtolower($array['country'])]) {
                $array['country'] = $country;
            }
        }

        return $array;
    }
}