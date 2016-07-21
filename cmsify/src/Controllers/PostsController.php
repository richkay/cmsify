<?php namespace Cmsify\Controllers;

use Cmsify\Post;
use Illuminate\Http\Request;
use Cmsify\Jobs\PostUpdateJob;
use Cmsify\Jobs\PostCreateJob;
use Cmsify\Jobs\PostDeleteJob;
use App\Http\Controllers\Controller;
use Cmsify\Requests\PostCreateRequest;
use Cmsify\Controllers\Transformers\PostsTransformer;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @return Response
     */
    public function index($categoryId = null)
    {
        $query = Post::query();

        if ($categoryId)
        {
            $query->whereHas('categories', function ($q) use ($categoryId)
            {
                $q->where('category_id', $categoryId);
            });
        }

        return $query->get()->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostsTransformer $postsTransformer
     * @param PostCreateRequest $request
     * @return Response
     */
    public function store(PostsTransformer $postsTransformer, PostCreateRequest $request)
    {
        return $postsTransformer->transform($this->dispatch(new PostCreateJob($request)));
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
        return $postsTransformer->transform(Post::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostsTransformer $postsTransformer
     * @param PostCreateRequest $request
     * @param  int $id
     * @return Response
     */
    public function update(PostsTransformer $postsTransformer, PostCreateRequest $request, $id)
    {
        return $postsTransformer->transform(
            $this->dispatch(new PostUpdateJob($request, $id))
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