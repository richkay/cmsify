<?php

\Route::get('/', function ()
{
    return view('cmsify');
});

\Route::group(['prefix' => 'api'], function ()
{
    \Route::resource('categories/hierarchy', 'CategoriesController@hierarchy');
    \Route::resource('categories', 'CategoriesController');

    \Route::resource('posts', 'PostsController');
    \Route::get('categories/{categoryId}/posts', 'PostsController@index');

    \Route::resource('tags', 'TagsController');
});
