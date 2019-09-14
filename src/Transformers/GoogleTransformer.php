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

        $result = [];

        foreach ($this->collection as $value) {
            foreach ($value as $val) {
                $result [] = [
                    'url' => $val['link'],
                    'title' => $val['title'],
                    'body' => strip_tags($val['snippet']),
                    'queryTime' => '',
                    'date' => '',
                ];
            }
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
