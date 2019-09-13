<?php

namespace Empact\WebMonitor\Transformers;

class VigoTransformer implements TransformerInterface
{
    /**
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

        foreach ($this->collection as $item) {
            $result [] = [
                'url' => $item['link'],
                'title' => $item['title'],
                'body' => $item['text'],
                'queryTime' => '',
                'date' => $item['date']
            ];
        }

        return $result;
    }
}
