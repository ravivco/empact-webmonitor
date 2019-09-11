<?php

namespace Empact\WebMonitor;

use Abraham\TwitterOAuth\TwitterOAuth;
use Empact\WebMonitor\Clients\GoogleClient;
use Empact\WebMonitor\Drivers\BaseMonitor;
use Empact\WebMonitor\Drivers\GoogleMonitor;
use Empact\WebMonitor\Drivers\TwitterMonitor;
use GuzzleHttp\Client;
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

        $this->bindTwitterMonitor();

        $this->bindGoogleMonitor();
    }

    protected function bindTwitterMonitor()
    {
        return $this->app->bind(TwitterMonitor::class, function () {
            $connection = new TwitterOAuth(
                config('empact-web-monitor.twitter.consumer_key'),
                config('empact-web-monitor.twitter.consumer_secret'),
                config('empact-web-monitor.twitter.access_token'),
                config('empact-web-monitor.twitter.access_token_secret')
            );
            return new TwitterMonitor($connection);
        });
    }

    protected function bindGoogleMonitor()
    {
        return $this->app->bind(GoogleMonitor::class, function () {
            $connection = new GoogleClient(
                config('empact-web-monitor.google.api_key'),
                config('empact-web-monitor.google.search_engine_id'),
                new Client()
            );
            return new GoogleMonitor($connection);
        });
    }
}
