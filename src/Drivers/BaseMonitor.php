<?php

namespace Empact\WebMonitor\Drivers;

class BaseMonitor
{
    public $twitterMonitor;

    public const TWITTER = 'twitter';
    public const GOOGLE = 'google';
    public const VIGO = 'vigo';

    public static $monitors = [
        self::TWITTER => TwitterMonitor::class,
        self::GOOGLE => GoogleMonitor::class,
        self::VIGO => VigoMonitor::class
    ];

    public function search(string $keyword)
    {
        return (new TwitterMonitor)->search($keyword);
    }
}
