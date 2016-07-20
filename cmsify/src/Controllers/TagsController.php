<?php namespace Cmsify\Controllers;

use Cmsify\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Tag::get()->all();
    }

    public function search(Request $request)
    {

        if (substr($request->get('q'), -1) == ' ')
        {
            Tag::create([
                'user_id' => $request->user()->id,
                'name' => $request->get('q')
            ]);
            sleep(0.5);
        }

        return Tag::where('name', 'like', $request->get('q') . '%')->get()->map(function ($item)
        {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->all();
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

    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($id)
    {
    }

}