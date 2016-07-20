<?php namespace Cmsify\Controllers;

use Cmsify\Category;
use Cmsify\Comment;
use Cmsify\Jobs\PostCreateJob;
use Cmsify\Jobs\PostDeleteJob;
use Cmsify\Post;
use Cmsify\Requests\PostCreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesPostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $categoryId
     * @return Response
     */
    public function index($categoryId)
    {
        $comment = factory(Comment::class)->create();
        $post = $comment->post;
        $post->categories()->attach($categoryId);

        return Post::whereHas('categories', function($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })->get()->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @param $categoryId
     * @return Response
     */
    public function store(PostCreateRequest $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $post = $this->dispatch(new PostCreateJob($request));
        $post->categories()->attach($categoryId);

        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $categoryId, $id)
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