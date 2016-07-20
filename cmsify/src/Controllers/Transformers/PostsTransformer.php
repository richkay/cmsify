<?php namespace Cmsify\Controllers\Transformers;

class PostsTransformer extends AbstractTransformer
{

    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'title' => $item['title'],
            'text' => $item['text'],
            'tags' => $item->tags,
            'categories' => $item->categories,
        ];
    }
}