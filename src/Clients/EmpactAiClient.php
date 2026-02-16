<?php

namespace Empact\WebMonitor\Clients;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;

class EmpactAiClient extends BaseClient implements ClientInterface
{

    protected $results_type_options = [
        'All' => 'RecentAll?',
        'Keywords' => 'GetKeywords?'
    ];


    /**
     * @var string
     */
    protected $api_url;

    /** @var string[] */
    protected array $allowed_query_params = ['keyword', 'start_index', 'conversation_details.updated_at', 'conversation_id', 'client_details.brand_id'];

    /** @var array */
    protected array $queryParams = [];

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

    public function getProviderConfigByKey(string $key)
    {
        return config('empact-web-monitor.empactai')[$key];
    }
    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->getProviderConfigByKey('api_endpoint');
    }

    public function getQuery()
    {
        if (is_null($this->token)) {
            throw new Exception("Please provide a valid bearer token");
        }

        $params = $this->getQueryParams();
        $payload = ['query_string' => $params];

        $url = $this->getApiUrl();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => $payload
        ];

        try {
            $result = $this->client->post($url, $options);
            return json_decode($result->getBody(), true);
        } catch (\Throwable $e) {
            return $this->handleHttpException($e, 'EmpactAi', $url);
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
        } catch (\Throwable $e) {
            return $this->handleHttpException($e, 'EmpactAi', $url);
        }
    }
}
