<?php

namespace Empact\WebMonitor\Clients;

use Exception;
use GuzzleHttp\Client;

class VigoClient implements ClientInterface
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $baseUrl = 'http://192.118.60.25/VigoRecent/api/Posts/RecentKW?id=633590419&';

    public function __construct($token, Client $client)
    {
        $this->token = $token;

        $this->client = $client;
    }

    public function getQuery($query)
    {
        if (is_null($this->token)) {
            throw new Exception("Please provide a valid vigo token");
        }

        $result = $this->client->get($this->baseUrl . $this->buildQuery($query));

        return json_decode($result->getBody(), true);
    }

    protected function buildQuery($query)
    {
        return http_build_query([
            'c2r' => $this->token,
            'keyword' => urlencode($query)
        ]);
    }
}
