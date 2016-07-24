<?php namespace Cmsify\Jobs;

use App\Jobs\Job;
use Cmsify\Post;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class PostUpdateJob extends Job implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var
     */
    private $id;

    /**
     * PostDeleteJob constructor.
     * @param Request $request
     * @param $id
     */
    public function __construct(Request $request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function handle()
    {
        $post = app(Post::class);
        $post = $post->findOrFail($this->id);
        $post->fill($this->request->only('state', 'title', 'slug', 'text', 'keywords', 'description'));
        $post->save();

        if (is_array($this->request->get('tags')))
        {
            $post->tags()->sync(array_pluck($this->request->get('tags'), 'id'));
        }
        if (is_array($this->request->get('categories')))
        {
            $post->categories()->sync(array_pluck($this->request->get('categories', []), 'id'));
        }

        $relations = config('cmsify.models.post.relations');

        foreach ($relations as $relation => $options)
        {
            if ($this->request->has($relation))
            {
                $relationData = $this->request->get($relation, []);
                if (isset($relationData['id']))
                {
                    $post->{$relation}()->sync([$relationData['id']]);
                } else
                {
                    $post->{$relation}()->sync(array_pluck($relationData, 'id'));
                }

            }
        }

        return $post;
    }
}