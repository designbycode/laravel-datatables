<?php

namespace Designbycode\Datatables\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Designbycode\Datatables\Http\Controllers\DatatablesController
 */
class Datatables extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Designbycode\Datatables\Http\Controllers\DatatablesController::class;
    }
}
