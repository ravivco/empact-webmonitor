<?php

namespace Empact\WebMonitor\Transformers;

class GoogleTransformer implements TransformerInterface
{
    /**
     *
     * @var array
     */
    protected $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function transform()
    {
        if (array_key_exists('error', $this->collection)) {
            return $this->collection;
        }

        $queryTime = $this->queryTime();

        $result = [];

        foreach ($this->collection['items'] as $value) {
            $result [] = [
                  'url' => $value['link'],
                  'title' => $value['title'],
                  'body' => strip_tags($value['snippet']),
                  'queryTime' => $queryTime,
                  'date' => '',
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
