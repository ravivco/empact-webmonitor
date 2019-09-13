<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\TwitterClient;
use Empact\WebMonitor\Transformers\TwitterTransformer;

class TwitterMonitor implements DriverInterface
{
    /**
     * @var \Empact\WebMonitor\Clients\TwitterClient
     */
    protected $twitter;

    public function __construct(TwitterClient $twitter)
    {
        $this->twitter = $twitter;
    }

    public function search(string $keyword)
    {
        $results = $this->twitter->getQuery($keyword);

        return (new TwitterTransformer($results))->transform();
    }
}
