<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\GoogleClient;
use Empact\WebMonitor\Transformers\GoogleTransformer;

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
        $results = $this->google->getQuery($keyword);

        return (new GoogleTransformer($results))->transform();
    }
}
