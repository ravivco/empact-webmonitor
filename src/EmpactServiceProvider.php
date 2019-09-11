<?php

namespace Empact\WebMonitor;

use Abraham\TwitterOAuth\TwitterOAuth;
use Empact\WebMonitor\Drivers\BaseMonitor;
use Empact\WebMonitor\Drivers\TwitterMonitor;
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

        $this->app->bind(TwitterMonitor::class, function () {
            $connection = new TwitterOAuth(
                config('empact-web-monitor.twitter.consumer_key'),
                config('empact-web-monitor.twitter.consumer_secret'),
                config('empact-web-monitor.twitter.access_token'),
                config('empact-web-monitor.twitter.access_token')
            );

            return new TwitterMonitor($connection);
        });
    }
}
