<?php

namespace Empact\WebMonitor;

use Abraham\TwitterOAuth\TwitterOAuth;
use Empact\WebMonitor\Clients\AiClient;
use Empact\WebMonitor\Clients\GoogleClient;
use Empact\WebMonitor\Clients\TwitterClient;
use Empact\WebMonitor\Clients\VigoClient;
use Empact\WebMonitor\Drivers\AiMonitor;
use Empact\WebMonitor\Drivers\BaseMonitor;
use Empact\WebMonitor\Drivers\GoogleMonitor;
use Empact\WebMonitor\Drivers\TwitterMonitor;
use Empact\WebMonitor\Drivers\VigoMonitor;
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

        $this->bindVigoMonitor();

        $this->bindAiMonitor();
    }

    protected function bindTwitterMonitor()
    {
        return $this->app->bind(TwitterMonitor::class, function () {
            $twitterOauth = new TwitterOAuth(
                config('empact-web-monitor.twitter.consumer_key'),
                config('empact-web-monitor.twitter.consumer_secret'),
                config('empact-web-monitor.twitter.access_token'),
                config('empact-web-monitor.twitter.access_token_secret')
            );
            $connection = new TwitterClient($twitterOauth);

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

    protected function bindVigoMonitor()
    {
        return $this->app->bind(VigoMonitor::class, function () {
            $connection = new VigoClient(
                config('empact-web-monitor.vigo.token'),
                new Client()
            );
            return new VigoMonitor($connection);
        });
    }
    protected function bindAiMonitor()
    {
        return $this->app->bind(AiMonitor::class, function () {
            $connection = new AiClient(
                config('empact-web-monitor.ai.bearer_token'),
                new Client()
            );
            return new AiMonitor($connection);
        });
    }
}
