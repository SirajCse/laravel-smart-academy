<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Mailgateway extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\MailgatewayService::class;
    }
}
