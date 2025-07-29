<?php

namespace Empact\WebMonitor\Clients;

use Exception;
use GuzzleHttp\Client;

class VigoClient extends BaseClient implements ClientInterface
{

    protected $results_type_options = [
        'All' => 'RecentAll?',
        'Brand' => 'Recent?',
        'Keywords' => 'GetKeywords?'
    ];

    /**
     * @var string
     */
    protected $api_base_url = 'https://api.ifat.com/VigoRecent/api/Posts/';

    /**
     * @var string
     */
    protected $api_url;

    public $allowed_query_params = ['c2r', 'keyword', 'start_index', 'results_type'];

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
        $type = $this->getQueryParam('results_type') ?: 'All';

        return $this->results_type_options[$type];
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->api_base_url.$this->getResultsType();
    }

    public function getQuery()
    {
        if (is_null($this->token)) {
            throw new Exception("Please provide a valid vigo token");
        }

        try {
            $result = $this->client->get($this->getApiUrl() . $this->buildQuery());
            $result_data = json_decode($result->getBody(), true);
            // Check if the given response array has error.
            if ($this->resultHasError($result_data)) {
                return [
                    'error' => [
                        'message' => $result_data['error'] ?? null,
                    ],
                ];
            }
            return $result_data;
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
            $result = $this->client->get($this->getApiUrl() . $this->buildQuery());
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
            'c2r' => $this->getQueryParam('c2r') ?: $this->token,
            'keyword' => $this->getQueryParam('keyword'),
            'id' => $this->getQueryParam('start_index')
        ]);
    }

    /**
     * Checks if the given response array contains an error key.
     *
     * @param array $response The response array to check for errors.
     * @return bool Returns true if the 'error' key exists in the response array, otherwise false.
     */
    private function resultHasError(array $response): bool
    {
        return array_key_exists('error', $response);
    }
}
