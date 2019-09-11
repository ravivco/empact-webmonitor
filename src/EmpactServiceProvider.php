<?php

namespace Empact\WebMonitor;

use Empact\WebMonitor\Drivers\BaseMonitor;
use Illuminate\Support\ServiceProvider;

class EmpactServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/empact-web-monitor.php' => config_path('empact-web-monitor.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/empact-web-monitor.php', 'empact-web-monitor');
        
        $this->app->bind('empact-web-monitor', function () {
            return new BaseMonitor();
        });
    }
}
