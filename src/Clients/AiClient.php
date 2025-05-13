<?php

namespace Empact\WebMonitor\Clients;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AiClient extends BaseClient implements ClientInterface
{

    protected $results_type_options = [
        'All' => 'RecentAll?',
        'Keywords' => 'GetKeywords?'
    ];


    /**
     * @var string
     */
    protected $api_url;

    public $allowed_query_params = ['keyword', 'start_index', 'dates'];

    public function __construct($token, Client $client)
    {
        $this->token = $token;

        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getResultsType(): string
    {
        $type = $this->getQueryParam('results_type');

        return $this->results_type_options[$type];
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return config('empact-web-monitor.empactai.api_endpoint');
    }

    public function getQuery()
    {
        if (is_null($this->token)) {
            throw new Exception("Please provide a valid bearer token");
        }

        try {
            $result = $this->client->post($this->getApiUrl(), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'query_string' => [
                        'conversation_details.updated_at' => [
                            'gte' => $this->getDate()
                        ]
                    ]
                ]
            ]);
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
            $result = $this->client->post($this->getApiUrl(), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json',
                ]
            ]);
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
            'keyword' => $this->getQueryParam('keyword'),
            'id' => $this->getQueryParam('start_index'),
            'dates' => $this->getQueryParam('dates')
        ]);
    }

    protected function getDate(){
        $originalDate = $this->getQueryParam('dates');

        $date = new \DateTime($originalDate);

        $date->setTimezone(new \DateTimeZone('UTC'));

        $formatted = $date->format('Y-m-d\TH:i:s\Z');

    }
}
