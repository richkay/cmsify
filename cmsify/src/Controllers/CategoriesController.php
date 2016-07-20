<?php namespace Cmsify\Controllers;

use Cmsify\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function search(Request $request)
    {
        return Category::where('name', 'like', trim($request->get('q')) . '%')->get()->map(function ($item)
        {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->all();
    }

    public function hierarchy()
    {
        $rootNode = Category::roots()->first();
        if ( ! $rootNode)
        {
            $rootNode = $this->createRootNode();
        }

        $tree = $rootNode->getDescendantsAndSelf(['id', 'parent_id', 'name'])->toHierarchy();

        return \Response::json($tree);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $newNode = Category::findOrFail($request->get('id'))->children()->create([
            'name' => $request->get('name', 'new Node')
        ]);

        return $newNode;

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
        $node = Category::findOrFail($id)->update([
            'name' => $request->get('name')
        ]);

        return \Response::json($node);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $node = Category::findOrFail($id);
        $node->delete();

        return $node;
    }

    protected function createRootNode($name = "Root Node")
    {
        $rootNode = Category::create([
            'name' => $name
        ]);
        $rootNode->makeRoot();

        return $rootNode;
    }

}