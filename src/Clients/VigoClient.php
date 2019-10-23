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
    protected $searchKeywordsUrl = 'http://192.118.60.25/VigoRecent/api/Posts/RecentKW?id=633590419&';

    /**
     * @var string
     */
    protected $getKeywordsUrl = 'http://192.118.60.25/VigoRecent/api/Posts/GetKeywords?c2r=h3B419qtAaZ1dVOmvyXKhNfbrOK9JCkULc1omlooSIQ_EQU_';

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

        try {
            $result = $this->client->get($this->searchKeywordsUrl . $this->buildQuery($query));
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

    public function getKeywords()
    {
        try {
            $result = $this->client->get($this->getKeywordsUrl);
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
            'c2r' => $this->token,
            'keyword' => $query
        ]);
    }
}
