<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ModuleLib extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\ModuleLibService::class;
    }
}
