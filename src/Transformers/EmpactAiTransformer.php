<?php

namespace Empact\WebMonitor\Transformers;

use Illuminate\Support\Facades\Log;

class EmpactAiTransformer implements TransformerInterface
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

        $hits = $this->collection['hits']['hits'] ?? [];

        foreach ($hits as $item) {
            $source = $item['_source'] ?? [];
            $conversation = $source['conversation_details'] ?? [];
            $relationType = $source['relation_type'] ?? [];
            $clientDetails = $source['client_details'] ?? [];

            $result[] = [
                'api_id' => $source['conversation_id'] ?? null,
                'media' => $conversation['platform'] ?? null,
                'url' => $conversation['related_url'] ?? null,
                'title' => $conversation['title'] ?? null,
                'body' => $conversation['body'] ?? null,
                'author' => null,
                'date' => $conversation['post_date'] ?? null,
                'query_text' => $this->generateQueryText($item),
                'query_time' => '',
                'api_brand_name' => $clientDetails['brand_name'] ?? null,
                'api_brand_id' => $clientDetails['brand_id'] ?? null,
            ];
        }

        return $result;
    }


    protected function generateQueryText(array $item)
    {
        $keywords = $item['_source']['conversation_details']['keywords'] ?? [];

        if (!empty($keywords)) {
            return implode(', ', $keywords);
        }

        return $item['keyword'] ?? ($item['highlights'] ?? null);
    }

}
