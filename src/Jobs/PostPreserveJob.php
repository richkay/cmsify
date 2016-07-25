<?php namespace Cmsify\Jobs;

use App\Jobs\Job;
use Cmsify\Post;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class PostPreserveJob extends Job implements SelfHandling
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
    public function __construct(Request $request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function handle(Post $post)
    {
        $post = $this->syncCustomRelations(
            $this->syncRelations(
                $this->preservePost($post)
            )
        );

        return $post;
    }


    /**
     * @param Post $post
     * @return Post
     */
    protected function preservePost(Post $post)
    {
        if ($this->id)
        {
            $post = $post->findOrFail($this->id);
            $post->slug = $this->request->get('slug');
        } else
        {
            $post->user_id = $this->request->user()->id;
            $post->slug = $this->generateSlug();
        }

        $post->fill($this->request->only('state', 'title', 'text', 'keywords', 'description'));
        $post->save();

        return $post;
    }

    /**
     * @param Post $post
     * @return Post
     */
    protected function syncCustomRelations(Post $post)
    {
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

    /**
     * @param Post $post
     * @return Post
     */
    protected function syncRelations(Post $post)
    {
        if (is_array($this->request->get('tags')))
        {
            $post->tags()->sync(array_pluck($this->request->get('tags'), 'id'));
        }

        if ( ! config('cmsify.categories.disbaled') && is_array($this->request->get('categories')))
        {
            $post->categories()->sync(array_pluck($this->request->get('categories', []), 'id'));
        }

        return $post;
    }

    /**
     * @return string
     */
    protected function generateSlug()
    {
        $slug = str_slug($this->request->get('title'));
        $uniqueSlug = $slug;
        $i = 1;
        while ($post = Post::whereSlug($uniqueSlug)->get()->first())
        {
            $uniqueSlug = $slug . '-' . $i++;
        }

        return $uniqueSlug;
    }
}