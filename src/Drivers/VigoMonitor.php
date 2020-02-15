<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\VigoClient;
use Empact\WebMonitor\Transformers\VigoTransformer;

class VigoMonitor implements DriverInterface
{
    /**
     * @var Empact\WebMonitor\Clients\VigoClient
     */
    protected $vigoClient;

    public function __construct(VigoClient $vigoClient)
    {
        $this->vigoClient = $vigoClient;
    }

    public function init(array $query)
    {
        $this->vigoClient->init($query);

        return $this;
    }

    public function search()
    {
        $results = $this->vigoClient->getQuery();

        return (new VigoTransformer($results))->transform();
    }

    public function getKeywords()
    {
        return $this->vigoClient->getKeywords();
    }
}
