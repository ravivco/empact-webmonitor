<?php

namespace Empact\WebMonitor\Transformers;

class TwitterTransformer implements TransformerInterface
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

        foreach ($this->collection->statuses as $status) {
            $result [] = [
                  'url' => '',
                  'title' => '',
                  'body' => strip_tags($status->text),
                  'queryTime' => '',
                  'date' => ''
              ];
        }

        return $result;
    }
}
