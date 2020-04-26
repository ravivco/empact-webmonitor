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
                'api_id' => isset($item['postID']) ? $item['postID'] : null,
                'media' => isset($item['media']) ? $item['media'] : null,
                'url' => isset($item['link']) ? $item['link'] : null,
                'title' => isset($item['title']) ? $item['title'] : null,
                'body' => isset($item['text']) ? $item['text'] : null,
                'date' => isset($item['date']) ? $item['date'] : null,
                'query_text' => (isset($item['keyword']) && isset($item['highlights'])) ? $item['keyword']." - ".$item['highlights'] : (isset($item['highlights']) ? $item['highlights'] : null),
                'query_time' => '',
                'api_brand_name' => isset($item['brand_name']) ? $item['brand_name'] : null,
                'api_brand_id' => isset($item['brand_id']) ? $item['brand_id'] : null
            ];
        }

        return $result;
    }
}
