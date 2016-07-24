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
     * @return string
     */
    protected function getSlug()
    {
        $slug = str_slug($this->request->get('title'));
        $i = 0;
        while (Post::whereSlug($slug)->first() && $i++)
        {
            $slug .= '-' . $i;
        }
        return $slug;
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
        if (is_array($this->request->get('categories')))
        {
            $post->categories()->sync(array_pluck($this->request->get('categories', []), 'id'));
        }

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
        } else
        {
            $post->user_id = $this->request->user()->id;
            $post->slug = $this->generateSlug();
        }

        $post->fill($this->request->only('state', 'title', 'slug', 'text', 'keywords', 'description'));
        $post->save();

        return $post;
    }
}