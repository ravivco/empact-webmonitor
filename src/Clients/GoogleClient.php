<?php

namespace Empact\WebMonitor\Clients;

use Exception;
use GuzzleHttp\Client;

class GoogleClient extends BaseClient implements ClientInterface
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
    protected $api_url = 'https://www.googleapis.com/customsearch/v1?';

    public $allowed_query_params = ['keyword', 'start_index'];

    public function __construct($apiKey, $searchEngineId, Client $client)
    {
        $this->apiKey = $apiKey;

        $this->searchEngineId = $searchEngineId;

        $this->client = $client;
    }

    public function getQuery()
    {
        if (is_null($this->searchEngineId)) {
            throw new Exception('You must specify a searchEngineId');
        }

        if (is_null($this->apiKey)) {
            throw new Exception("You must specify a google API key");
        }

        $results = [];

        $incrementBy = 10;

        $searchCount = config('empact-web-monitor.google.search_count');

        for ($i = 1, $startIndex = $incrementBy; $i <= $searchCount; $i++, $startIndex += $incrementBy) {
            try {
                $result = $this->client->get($this->api_url . $this->buildQuery());
                $body = json_decode($result->getBody(), true);
                array_push($results, $body['items']);
            } catch (\Throwable $e) {
                return $this->handleHttpException($e, 'Google', $url);
            }
        }

        return $results;
    }

    protected function buildQuery()
    {
        return http_build_query([
            'key' => $this->apiKey,
            'cx' => $this->searchEngineId,
            'q' => $this->getQueryParam('keyword'),
            'start' => $this->getQueryParam('start_index')
        ]);
    }
}
