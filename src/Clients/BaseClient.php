<?php

namespace Empact\WebMonitor\Clients;


use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class BaseClient
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;
    
    public $query_params;

    /**
     * @return array
     */
    protected function getQueryParams()
    {
        return $this->query_params;
    }

    /**
     * @param array $query_params
     */
    protected function setQueryParams($query_params): void
    {
        $this->resetQueryParams();
        $this->query_params = $query_params;
    }

    protected function resetQueryParams()
    {
        unset($this->query_params);
    }

    /**
     * @param string $param
     * @return mixed|null
     */
    public function getQueryParam(string $param)
    {
        if (!empty($param) && isset($this->getQueryParams()[$param])) {
            return $this->getQueryParams()[$param];
        }

        return null;
    }

    /**
     * @param array $query
     * @return array
     */
    protected function extractQueryParams(array $query)
    {
        $query_params = [];
        
        foreach ($query as $key => $value) {
            if (in_array($key, $this->allowed_query_params)) {
                $query_params[$key] = $value;
            }
        }
        
        return $query_params;
    }

    /**
     * @param array $query
     */
    public function init(array $query)
    {
        $this->setQueryParams($this->extractQueryParams($query));
    }

    /**
     * Handle Guzzle HTTP exceptions and return a structured error response
     *
     * @param \Throwable $e The exception thrown during the HTTP request
     * @param string $context Context identifier for logging (e.g., 'EmpactAi', 'Vigo')
     * @param string|null $url Optional URL for logging context
     * @return array Structured error response
     */
    protected function handleHttpException(\Throwable $e, string $context, ?string $url = null): array
    {
        $logContext = ['message' => $e->getMessage()];

        if ($url) {
            $logContext['url'] = $url;
        }

        if ($e instanceof ConnectException) {
            // No HTTP response exists (network/timeout errors)
            $logContext['handler_context'] = $e->getHandlerContext();
            logger()->error("{$context} ConnectException", $logContext);

            return [
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 0,
                ],
            ];
        }

        if ($e instanceof RequestException) {
            // Might have HTTP response (4xx/5xx errors)
            $response = $e->getResponse();
            $logContext['status'] = $response?->getStatusCode();
            $logContext['body'] = $response ? (string) $response->getBody() : null;

            logger()->error("{$context} RequestException", $logContext);

            return [
                'error' => [
                    'message' => $response ? (string) $response->getBody() : $e->getMessage(),
                    'code' => $response?->getStatusCode() ?? 0,
                ],
            ];
        }

        // Unexpected errors
        logger()->error("{$context} Unexpected error", $logContext);

        return [
            'error' => [
                'message' => $e->getMessage(),
                'code' => 0,
            ],
        ];
    }
}