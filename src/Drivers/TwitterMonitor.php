<?php

namespace Empact\WebMonitor\Drivers;

use Empact\WebMonitor\Clients\TwitterClient;
use Empact\WebMonitor\Transformers\TwitterTransformer;

class TwitterMonitor implements DriverInterface
{
    /**
     * @var \Empact\WebMonitor\Clients\TwitterClient
     */
    protected $twitterClient;

    public function __construct(TwitterClient $twitterClient)
    {
        $this->twitterClient = $twitterClient;
    }

    public function init(array $query)
    {
        $this->twitterClient->init($query);

        return $this;
    }

    public function search(string $keyword = null)
    {
        $results = $this->twitterClient->getQuery($keyword);

        return (new TwitterTransformer($results))->transform();
    }
}
