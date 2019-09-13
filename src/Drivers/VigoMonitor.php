<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\VigoClient;
use Empact\WebMonitor\Transformers\VigoTransformer;

class VigoMonitor implements DriverInterface
{
    /**
     * @var Empact\WebMonitor\Clients\VigoClient
     */
    protected $vigo;

    public function __construct(VigoClient $vigo)
    {
        $this->vigo = $vigo;
    }

    public function search(string $keyword)
    {
        $results = $this->vigo->getQuery($keyword);

        return (new VigoTransformer($results))->transform();
    }
}
