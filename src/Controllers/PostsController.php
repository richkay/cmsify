<?php namespace Cmsify\Controllers;

use Cmsify\Jobs\PostPreserveJob;
use Cmsify\Post;
use Cmsify\Jobs\PostDeleteJob;
use App\Http\Controllers\Controller;
use Cmsify\Requests\PostFormRequest;
use Cmsify\Controllers\Transformers\PostsTransformer;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @param Post $post
     * @return Response
     */
    public function index($categoryId = null, Post $post)
    {
        if ($categoryId)
        {
            $post->whereHas('categories', function ($q) use ($categoryId)
            {
                $q->where('category_id', $categoryId);
            });
        }

        return $post->get()->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @param PostsTransformer $postsTransformer
     * @param Post $post
     * @return Response
     */
    public function create(PostsTransformer $postsTransformer, Post $post)
    {
        return $postsTransformer->transform($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostsTransformer $postsTransformer
     * @param PostFormRequest $request
     * @return Response
     */
    public function store(PostsTransformer $postsTransformer, PostFormRequest $request)
    {
        return $postsTransformer->transform($this->dispatch(new PostPreserveJob($request)));
    }

    /**
     * Display a listing of the resource.
     *
     * @param PostsTransformer $postsTransformer
     * @param $id
     * @return Response
     */
    public function show(PostsTransformer $postsTransformer, $id)
    {
        $post = app(Post::class);
        return $postsTransformer->transform($post->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostsTransformer $postsTransformer
     * @param PostFormRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(PostsTransformer $postsTransformer, PostFormRequest $request, $id)
    {
        return $postsTransformer->transform(
            $this->dispatch(new PostPreserveJob($request, $id))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->dispatch(new PostDeleteJob($id));
    }

}