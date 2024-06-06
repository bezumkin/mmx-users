<?php

namespace MMX\Users\Controllers\Mgr;

use Illuminate\Database\Capsule\Manager;
use MODX\Revolution\modX;
use MODX\Revolution\Processors\System\Country\GetList;
use Psr\Http\Message\ResponseInterface;
use Vesp\Controllers\Controller;

class Countries extends Controller
{
    protected modX $modx;

    public function __construct(Manager $eloquent, modX $modx)
    {
        parent::__construct($eloquent);
        $this->modx = $modx;
    }

    public function get(): ResponseInterface
    {
        $processor = new GetList($this->modx, $this->getProperties());
        $countries = $processor->getCountryList();
        $rows = [];
        foreach ($countries as $key => $country) {
            if ($key) {
                $rows[] = ['id' => strtoupper($key), 'title' => $country];
            }
        }

        return $this->success([
            'total' => count($rows),
            'rows' => $rows,
        ]);
    }
}