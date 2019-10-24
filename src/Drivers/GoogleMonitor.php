<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\GoogleClient;
use Empact\WebMonitor\Transformers\GoogleTransformer;

class GoogleMonitor implements DriverInterface
{
    /**
     * @var \Empact\WebMonitor\Clients\GoogleClient
     */
    protected $googleClient;

    public function __construct(GoogleClient $googleClient)
    {
        $this->googleClient = $googleClient;
    }

    public function search(string $keyword)
    {
        $results = $this->googleClient->getQuery($keyword);

        return (new GoogleTransformer($results))->transform();
    }
}
