<?php namespace Cmsify\Jobs;

use App\Jobs\Job;
use Cmsify\Post;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

class PostCreateJob extends Job implements SelfHandling
{
    /**
     * @var Request
     */
    private $request;

    /**
     * PostDeleteJob constructor.
     * @param Request $request
     * @internal param int $id
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $post = app(Post::class);
        $post->fill(array_merge(
            ['user_id' => $this->request->user()->id],
            $this->request->only('state', 'title', 'text', 'keywords', 'description')
        ));

        $slug = str_slug($this->request->get('title'));
        $i = 0;
        while (Post::whereSlug($slug)->first() && $i++)
        {
            $slug .= '-' . $i;
        }

        $post->slug = $slug;
        $post->save();

        $post->tags()->sync(array_pluck($this->request->get('tags', []), 'id'));
        $post->categories()->sync(array_pluck($this->request->get('categories', []), 'id'));

        $relations = config('cmsify.models.post.relations');

        foreach ($relations as $relation => $options)
        {
            if ($this->request->has($relation))
            {
                $post->{$relation}()->sync(array_pluck($this->request->get($relation, []), 'id'));
            }
        }

        return $post;
    }
}