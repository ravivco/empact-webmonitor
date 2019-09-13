<?php

namespace Empact\WebMonitor\Drivers;

use Exception;
use Illuminate\Support\Facades\App;

class BaseMonitor
{
    public const TWITTER = 'twitter';
    public const GOOGLE = 'google';
    public const VIGO = 'vigo';

    /**
     * The default monitors currently supported
     *
     * @var array
     */
    public static $defaultMonitors = [
         self::TWITTER => TwitterMonitor::class,
         self::GOOGLE => GoogleMonitor::class,
         self::VIGO => VigoMonitor::class
    ];

    /**
     *
     * @var array
     */
    public static $selectedMonitors;

    public function use(array $monitors)
    {
        $monitors = $this->formatSelectedMonitors($monitors);

        foreach ($monitors as $monitor) {
            if (! array_key_exists($monitor, self::$defaultMonitors)) {
                throw new Exception("Driver is not yet supported");
            }
        }

        self::$selectedMonitors = $monitors;

        return $this;
    }

    protected function formatSelectedMonitors($monitors)
    {
        return collect($monitors)->map(function ($monitor) {
            return str_replace(' ', '', (strtolower($monitor)));
        })->toArray();
    }

    public function search(string $keyword)
    {
        return empty(self::$selectedMonitors)
             ? $this->searchDefaultMonitors($keyword)
             : $this->searchSelectedMonitors($keyword);
    }

    protected function searchDefaultMonitors($keyword)
    {
        $results = [];

        foreach (self::$defaultMonitors as $key => $monitor) {
            $results[$key] = App::make($monitor)->search($keyword);
        }

        return $results;
    }

    protected function searchSelectedMonitors($keyword)
    {
        $results = [];

        foreach (self::$selectedMonitors as $monitor) {
            $results[$monitor] = App::make(self::$defaultMonitors[$monitor])->search($keyword);
        }

        return $results;
    }
}
