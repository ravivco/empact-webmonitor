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

        // dd($this->collection->statuses);
    }

    public function transform()
    {
        $result = [];

        foreach ($this->collection->statuses as $status) {
            $result [] = [
                  'body' => strip_tags($status->text)
              ];
        }

        return $result;
    }
}
