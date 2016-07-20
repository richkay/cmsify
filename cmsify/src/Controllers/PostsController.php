<?php namespace Cmsify\Controllers;

use Cmsify\Post;
use Illuminate\Http\Request;
use Cmsify\Jobs\PostCreateJob;
use Cmsify\Jobs\PostDeleteJob;
use Cmsify\Requests\PostCreateRequest;
use App\Http\Controllers\Controller;

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
     * @param PostCreateRequest $request
     * @param $categoryId
     * @return Response
     */
    public function store(PostCreateRequest $request, $categoryId = null)
    {
        if ($categoryId)
        {
            $category = Category::findOrFail($categoryId);
        }

        $post = $this->dispatch(new PostCreateJob($request));

        if ($category)
        {
            $post->categories()->attach($category->id);
        }

        return $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return Post::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->only('state', 'title', 'text', 'keywords', 'description'));
        $post->save();

        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $categoryId
     * @param  int $id
     * @return Response
     */
    public function destroy($categoryId, $id)
    {
        return $this->dispatch(new PostDeleteJob($id));
    }

}