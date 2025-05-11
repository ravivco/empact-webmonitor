<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\AiClient;
use Empact\WebMonitor\Transformers\AiTransformer;
use Illuminate\Support\Facades\Log;

class AiMonitor implements DriverInterface
{
    /**
     * @var Empact\WebMonitor\Clients\AiClient
     */
    protected $aiClient;

    public function __construct(AiClient $aiClient)
    {
        $this->aiClient = $aiClient;
    }

    public function init(array $query)
    {
        $this->aiClient->init($query);

        return $this;
    }

    public function search()
    {
        $results = $this->aiClient->getQuery();
        return (new AiTransformer($results))->transform();
    }

    public function getKeywords()
    {
        return $this->aiClient->getKeywords();
    }
}
