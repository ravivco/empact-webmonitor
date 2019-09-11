<?php

namespace Empact\WebMonitor\Transformers;

class GoogleTransformer implements TransformerInterface
{
    /**
     *
     * @var array
     */
    protected $collection;

    protected $queryTime;

    public function __construct($collection)
    {
        $this->collection = $collection;

        $this->queryTime = $this->queryTime();
    }

    public function transform()
    {
        $result = [];

        foreach ($this->collection['items'] as $value) {
            $result [] = [
                  'link' => $value['link'],
                  'title' => $value['title'],
                  'body' => strip_tags($value['snippet']),
                  'queryTime' => $this->queryTime
              ];
        }

        return $result;
    }

    public function queryTime()
    {
        foreach ($this->collection['searchInformation'] as $key => $value) {
            if ($key === 'searchTime') {
                return $this->queryTime = $value;
            }
        }
    }
}
