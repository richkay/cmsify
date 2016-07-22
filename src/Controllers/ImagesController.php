<?php

namespace Cmsify\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class ImagesController extends Controller
{

    // Route::get('images/posts|posts-text/800x800|original/my-image.jpg
    public function show($context, $version, $filename)
    {
        // intervention image caching
        // $image = Image::make($file->getRealPath())->save();

        $file = sprintf("%s/%s", $this->getTargetStoragePath($context), $filename);

        return \File::get($file);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|image|max:' . config('cmsify.images.maxfilesize'),
            'context' => 'required|in:posts-text,posts',
//            'id' => $request->has('context') ? 'required|exists:' . $request->get('context') . ',id,user_id,' . $this->user->id : 'required'
        ]);

        $context = $request->get('context');
        $file = $request->file('file');

        $targetPath = $this->getTargetStoragePath($context);
        $targetFilename = $this->getTargetFilename($file);
        $targetFile = sprintf("%s/%s", $targetPath, $targetFilename);

        if ( ! \File::exists($targetPath))
        {
            \File::makeDirectory($targetPath, 493, true);
        }

        if ( \File::exists($targetFile))
        {
            return sprintf('/cmsify/images/%s/original/%s', $context, $targetFilename);
        }

        $manager = new ImageManager(array('driver' => 'gd'));

        $image = $manager->make($file->getRealPath())->save(
            $targetFile,
            config('cmsify.images.quality', 65)
        );

        return sprintf('/cmsify/images/%s/original/%s', $context, $targetFilename);
    }

    /**
     * @param $file
     * @return string
     */
    protected function getTargetFilename($file)
    {
        $timestamp = (new Carbon())->format("Y-m-d");
        $substrLength = strlen($file->getClientOriginalName()) - strlen($file->getClientOriginalExtension());
        $sluggedFilename = str_slug(substr($file->getClientOriginalName(), 0, $substrLength));
        $targetFilename = $sluggedFilename . '-' . $timestamp . '.jpg';
        return $targetFilename;
    }

    /**
     * @param $context
     * @return string
     */
    protected function getTargetStoragePath($context)
    {
        $targetPath = sprintf("%s/%s", config('cmsify.images.storage_path'), $context);
        return $targetPath;
    }

}
