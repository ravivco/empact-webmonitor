<?php

namespace Empact\WebMonitor\Clients;

use Abraham\TwitterOAuth\TwitterOAuth;
use Exception;

class TwitterClient extends BaseClient implements ClientInterface
{
    public const SUCCESS = 200;

    /**
     * @var \Abraham\TwitterOauth\TwitterOauth
     */
    protected $twitterOAuth;

    public $allowed_query_params = ['keyword'];

    public function __construct(TwitterOAuth $twitterOAuth)
    {
        $this->twitterOAuth = $twitterOAuth;
    }

    public function getQuery()
    {
        $this->ensureConfigValuesArePresent();

        try {
            $result = $this->twitterOAuth->get('/search/tweets', $this->buildQuery());

            $statusCode = $this->twitterOAuth->getLastHttpCode();

            if ($statusCode == self::SUCCESS) {
                return $result;
            }

            // Handle non-success status codes
            $errorMessage = 'Unknown error occurred';
            $lastBody = $this->twitterOAuth->getLastBody();

            if (isset($lastBody->errors[0]->message)) {
                $errorMessage = $lastBody->errors[0]->message;
            }

            logger()->error('Twitter API error', [
                'status_code' => $statusCode,
                'message' => $errorMessage,
                'body' => $lastBody,
            ]);

            return [
                'error' => [
                    'message' => $errorMessage,
                    'code' => $statusCode
                ]
            ];
        } catch (\Throwable $e) {
            logger()->error('Twitter Unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return [
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 0,
                ],
            ];
        }
    }

    protected function ensureConfigValuesArePresent()
    {
        $configAttributes = config('empact-web-monitor.twitter');

        foreach ($configAttributes as $key => $item) {
            if (is_null($item)) {
                throw new Exception("Provide a ${key} key");
            }
        }
        return;
    }

    protected function buildQuery()
    {
        return [
            'count'=> 50,
            'include_entities' => true,
            'q' => $this->getQueryParam('keyword')
        ];
    }
}
