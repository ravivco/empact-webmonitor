<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\GoogleClient;

class GoogleMonitor implements DriverInterface
{
    /**
     * @var \Empact\WebMonitor\Clients\GoogleClient
     */
    protected $google;

    public function __construct(GoogleClient $google)
    {
        $this->google = $google;
    }

    public function search(string $keyword)
    {
        return $this->google->getQuery($keyword);
    }
}
