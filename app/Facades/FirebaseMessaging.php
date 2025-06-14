<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Kreait\Firebase\Messaging;

class FirebaseMessaging extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Messaging::class;
    }
}