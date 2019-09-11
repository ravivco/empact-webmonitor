<?php

namespace Empact\WebMonitor\Clients;

use GuzzleHttp\Client;

class GoogleClient implements ClientInterface
{
    /**
     * @var string
     */
    protected $searchEngineId;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $baseUrl = 'https://www.googleapis.com/customsearch/v1?';

    public function __construct($apiKey, $searchEngineId, Client $client)
    {
        $this->apiKey = $apiKey;
        
        $this->searchEngineId = $searchEngineId;

        $this->client = $client;
    }

    public function getQuery($query)
    {
        if ($this->searchEngineId == '') {
            throw new \Exception('You must specify a searchEngineId');
        }

        $result = $this->client->get($this->baseUrl . $this->buildQuery($query));

        return json_decode($result->getBody(), true);
    }

    protected function buildQuery($query)
    {
        return http_build_query([
                'key' => $this->apiKey,
                'cx' => $this->searchEngineId,
                'q' => urlencode($query)
            ]);
    }
}
