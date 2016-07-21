<?php namespace Cmsify\Controllers;

use Cmsify\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        if ( ! $request->has('q'))
        {
            return Tag::get()->all();
        }

        if (substr($request->get('q'), -1) == ' ')
        {
            $tag = Tag::firstOrNew([
                'name' => trim($request->get('q'))
            ]);
            if ( ! $tag->id)
            {
                $tag->user_id = $request->user()->id;
                $tag->save();
            }
            sleep(0.5);

            $tag->name = $request->get('q');
        }

        $tags = Tag::where('name', 'like', trim($request->get('q')) . '%')->get()->map(function ($item)
        {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->all();

        if (isset($tag))
        {
            array_push($tags, $tag);
        }

        return $tags;
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