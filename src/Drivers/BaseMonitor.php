<?php

namespace Empact\WebMonitor\Drivers;

use Exception;
use Illuminate\Support\Facades\App;

class BaseMonitor
{
    public const TWITTER = 'twitter';
    public const GOOGLE = 'google';
    public const VIGO = 'vigo';
    public const EMPACT_AI = 'ai';

    /**
     * The default monitors currently supported
     *
     * @var array
     */
    public static $defaultMonitors = [
        self::TWITTER => TwitterMonitor::class,
        self::GOOGLE => GoogleMonitor::class,
        self::VIGO => VigoMonitor::class,
        self::EMPACT_AI => AiMonitor::class
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

    /**
     * Search Default/Selected monitors by give query params (array)
     *
     * @param array $query
     * @return array
     */
    public function search(array $query)
    {
        return empty(self::$selectedMonitors)
            ? $this->searchDefaultMonitors($query)
            : $this->searchSelectedMonitors($query);
    }

    protected function searchDefaultMonitors(array $query)
    {
        $results = [];

        foreach (self::$defaultMonitors as $key => $monitor) {
            $api_monitor = App::make($monitor)->init($query);
            $results[$key] = $api_monitor->search();
        }

        return $results;
    }

    protected function searchSelectedMonitors(array $query)
    {
        $results = [];

        foreach (self::$selectedMonitors as $monitor) {
            $api_monitor = App::make(self::$defaultMonitors[$monitor])->init($query);
            $results[$monitor] = $api_monitor->search();
        }

        return $results;
    }

    public function getApiKeywords()
    {
        return App::make(self::$defaultMonitors[self::VIGO])->getKeywords();
    }
}
