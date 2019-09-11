<?php

namespace Empact\WebMonitor\Facades;

use Illuminate\Support\Facades\Facade;

class EmpactWebMonitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'empact-web-monitor';
    }
}
