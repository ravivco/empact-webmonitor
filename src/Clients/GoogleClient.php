<?php

namespace Empact\WebMonitor\Clients;

use Exception;
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
        if (is_null($this->searchEngineId)) {
            throw new Exception('You must specify a searchEngineId');
        }

        if (is_null($this->apiKey)) {
            throw new Exception("You must specify a google API key");
        }

        try {
            $result = $this->client->get($this->baseUrl . $this->buildQuery($query));
            return json_decode($result->getBody(), true);
        } catch (Exception $e) {
            $response = $e->getResponse();

            return [
                'error' => [
                    'message' => $response->getReasonPhrase(),
                    'code' => $response->getStatusCode()
                ]
            ];
        }
    }

    protected function buildQuery($query)
    {
        return http_build_query([
                'key' => $this->apiKey,
                'count' => 30,
                'cx' => $this->searchEngineId,
                'q' => $query
            ]);
    }
}
