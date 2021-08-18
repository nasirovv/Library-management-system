<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Image extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'image';
    }
}
