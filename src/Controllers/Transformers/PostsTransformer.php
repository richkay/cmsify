<?php namespace Cmsify\Controllers\Transformers;

class PostsTransformer extends AbstractTransformer
{

    public function transform($item)
    {
        $response = [
            'id' => $item['id'],
            'title' => $item['title'],
            'slug' => $item['slug'],
            'text' => $item['text'],
            'keywords' => $item['keywords'],
            'description' => $item['description'],
            'tags' => $item->tags,
            'categories' => $item->categories,
        ];

        $relations = config('cmsify.models.post.relations');

        foreach ($relations as $relation => $options)
        {
            if (isset($item->{$relation}))
            {
                $relationModel = app($options['model']);
                $response['relations'][] = array_merge(array_only($options, ['label', 'multiple']), [
                    'name' => $relation,
                    'options' => $relationModel->get()->all()
                ]);

                if ($options['multiple'])
                {
                    $response[$relation] = $item->{$relation};
                } else
                {
                    $response[$relation] = $item->{$relation}()->first();
                }
            }
        }

        return $response;

    }
}