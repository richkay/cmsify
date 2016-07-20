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
        $post = Post::findOrFail($this->id);
        $post->fill($this->request->only('state', 'title', 'text', 'keywords', 'description'));
        $post->save();
        $post->tags()->sync(array_pluck($this->request->get('tags'), 'id'));
        $post->categories()->sync(array_pluck($this->request->get('categories'), 'id'));

        return $post;
    }
}