<?php

namespace Empact\WebMonitor\Drivers;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterMonitor implements DriverInterface
{
    /**
     * @var string
     */
    public $keyword;
    
    /**
     * @var string
     */
    protected $consumerKey;

    /**
     * @var string
     */
    protected $consumerSecret;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $accessTokenSecret;

    /**
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $twitter;

    public function __construct()
    {
        $this->setUpConfig();
        $this->twitter = $this->setUpTwitterClient();
    }

    protected function setUpConfig()
    {
        $this->consumerKey = config('empact-web-monitor.twitter.consumer_key');
        $this->consumerSecret = config('empact-web-monitor.twitter.consumer_secret');
        $this->accessToken = config('empact-web-monitor.twitter.access_token');
        $this->accessTokenSecret = config('empact-web-monitor.twitter.access_token_secret');
    }

    protected function setUpTwitterClient()
    {
        return new TwitterOAuth(
            $this->consumerKey,
            $this->consumerSecret,
            $this->accessToken,
            $this->accessTokenSecret
        );
    }


    public function search(string $keyword)
    {
        return $this->twitter->get('search/tweets', ['q' => urlencode($keyword)]);
    }
}
