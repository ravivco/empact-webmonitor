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
        $result = [];

        foreach($this->collection as $item){
            $result [] = [
                'postId' => $item['postID'],
                'title' => $item['title'],
                'media' => $item['media'],
                'author' => $item['author'],
                'date' => $item['date'],
                'text' => $item['text'],
                'link' => $item['link'],
                'KeyWordName' => $item['keyword'] 
            ];
        }

        return $result;
    }
}