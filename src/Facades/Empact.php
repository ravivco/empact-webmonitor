<?php

namespace Empact\WebMonitor\Facades;

use Illuminate\Support\Facades\Facade;

class Empact extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'empact-web-monitor';
    }
}
