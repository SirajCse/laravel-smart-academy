<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MediaStorage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\MediaStorageService::class;
    }
}
