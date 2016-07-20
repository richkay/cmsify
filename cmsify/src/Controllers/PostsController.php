<?php namespace Cmsify\Controllers;

use Cmsify\Jobs\PostCreateJob;
use Cmsify\Jobs\PostDeleteJob;
use Cmsify\Post;
use Cmsify\Requests\PostCreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(PostCreateRequest $request)
    {
        return $this->dispatch(new PostCreateJob($request));
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
        $post->fill($request->only('title', 'text', 'keywords', 'description'));
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