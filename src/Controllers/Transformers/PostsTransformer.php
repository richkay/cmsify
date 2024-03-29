<?php namespace Cmsify\Controllers\Transformers;

class PostsTransformer extends AbstractTransformer
{

    public function transform($item)
    {
        $response = [
            'id' => $item['id'],
            'state' => $item['state'],
            'title' => $item['title'],
            'slug' => $item['slug'],
            'text' => $item['text'],
            'keywords' => $item['keywords'],
            'description' => $item['description'],
            'tags' => $item->tags,
            'categories' => $item->categories,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
            'canEdit' => true,
            'canDelete' => true,
        ];

        if (config('cmsify.permissions.onlyCreatorCanEdit') === true)
        {
            $response['canEdit'] = auth()->user()->id == $item->user_id;
        }

        if (config('cmsify.permissions.onlyCreatorCanDelete') === true)
        {
            $response['canDelete'] = auth()->user()->id == $item->user_id;
        }

        $response = $this->appendCustomRelations($item, $response);

        return $response;

    }

    /**
     * @param $item
     * @param $response
     * @return mixed
     */
    protected function appendCustomRelations($item, $response)
    {
        $relations = config('cmsify.models.post.relations');

        foreach ($relations as $relation => $options)
        {
            // !TODO do something like method_exists for $item->{$relation}()
            $relationModel = app(get_class($item->{$relation}()->getRelated()));
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

        return $response;
    }
}