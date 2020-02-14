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

    public function getQuery($query)
    {
        $this->ensureConfigValuesArePresent();

        $result = $this->twitterOAuth->get('/search/tweets', $this->buildQuery());

        $statusCode = $this->twitterOAuth->getLastHttpCode();

        if ($statusCode == self::SUCCESS) {
            return $result;
        }

        if ($statusCode !== self::SUCCESS) {
            $message = $this->twitterOAuth->getLastBody()->errors[0]->message;
            return [
                'error' => [
                    'message' => $message,
                    'code' => $statusCode
                ]
            ];
        }

        return $result;
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
