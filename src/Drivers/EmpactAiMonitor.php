<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\EmpactAiClient;
use Empact\WebMonitor\Transformers\EmpactAiTransformer;
use Illuminate\Support\Facades\Log;

class EmpactAiMonitor implements DriverInterface
{
    /**
     * @var EmpactAiClient
     */
    protected $aiClient;

    public function __construct(EmpactAiClient $aiClient)
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
        return (new EmpactAiTransformer($results))->transform();
    }

    public function getKeywords()
    {
        return $this->aiClient->getKeywords();
    }
}
