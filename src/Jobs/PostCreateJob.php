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
        $post = Post::create(array_merge(
            ['user_id' => $this->request->user()->id],
            $this->request->only('state', 'title', 'text', 'keywords', 'description')
        ));

        $post->tags()->sync(array_pluck($this->request->get('tags', []), 'id'));
        $post->categories()->sync(array_pluck($this->request->get('categories', []), 'id'));

        return $post;
    }
}