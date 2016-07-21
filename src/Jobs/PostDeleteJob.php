<?php namespace Cmsify\Jobs;

use App\Jobs\Job;
use Cmsify\Post;
use Illuminate\Contracts\Bus\SelfHandling;

class PostDeleteJob extends Job implements SelfHandling
{
    /**
     * @var int
     */
    private $id;

    /**
     * PostDeleteJob constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $post = Post::findOrFail($this->id);
        $post->categories()->detach();
        $post->delete();
        return $post;
    }
}