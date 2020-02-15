<?php

namespace Empact\WebMonitor\Clients;

use Exception;
use GuzzleHttp\Client;

class VigoClient extends BaseClient implements ClientInterface
{

    /**
     * @var string
     */
    protected $api_url = 'http://192.118.60.25/VigoRecent/api/Posts/RecentKW';

    /**
     * @var string
     */
    protected $getKeywordsUrl = 'http://192.118.60.25/VigoRecent/api/Posts/GetKeywords?c2r=h3B419qtAaZ1dVOmvyXKhNfbrOK9JCkULc1omlooSIQ_EQU_';

    public $allowed_query_params = ['keyword', 'start_index'];

    public function __construct($token, Client $client)
    {
        $this->token = $token;

        $this->client = $client;
    }

    public function getQuery()
    {
        if (is_null($this->token)) {
            throw new Exception("Please provide a valid vigo token");
        }

        try {
            $result = $this->client->get($this->api_url . $this->buildQuery());
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

    protected function buildQuery()
    {
        return http_build_query([
            'c2r' => $this->token,
            'keyword' => $this->getQueryParam('keyword'),
            'id' => $this->getQueryParam('start_index')
        ]);
    }
}
