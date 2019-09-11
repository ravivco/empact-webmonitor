<?php

namespace Empact\WebMonitor\Drivers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Empact\WebMonitor\Transformers\TwitterTransformer;

class TwitterMonitor implements DriverInterface
{
    /**
     * @var \Abraham\TwitterOAuth\TwitterOAuth
     */
    protected $twitter;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    public function search(string $keyword)
    {
        $results = $this->twitter->get('search/tweets', ['q' => urlencode($keyword)]);

        return (new TwitterTransformer($results))->transform();
    }
}
