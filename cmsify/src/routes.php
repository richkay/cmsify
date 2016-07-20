<?php

\Route::get('/', function ()
{
    return view('cmsify');
});

\Route::group(['prefix' => 'api'], function ()
{
    \Route::resource('categories', 'CategoriesController');
    \Route::resource('posts', 'PostsController');
    \Route::resource('categories.posts', 'PostsController');
    \Route::get('tags/search', 'TagsController@search');
    \Route::resource('tags', 'TagsController');
});
