<?php

namespace Empact\WebMonitor\Drivers;

use Illuminate\Support\Facades\App;

class BaseMonitor
{
    public $twitterMonitor;

    public const TWITTER = 'twitter';
    public const GOOGLE = 'google';
    public const VIGO = 'vigo';

    public static $monitors = [
         self::TWITTER => TwitterMonitor::class,
         self::GOOGLE => GoogleMonitor::class,
        // self::VIGO => VigoMonitor::class
    ];

    public function search(string $keyword)
    {
        $results = [];

        foreach (self::$monitors as $key => $monitor) {
            $results[$key] = App::make($monitor)->search($keyword);
        }

        return $results;
    }
}
