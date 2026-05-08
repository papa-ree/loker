<?php

namespace Bale\Loker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bale\Loker\Loker
 */
class Loker extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Bale\Loker\Loker::class;
    }
}
