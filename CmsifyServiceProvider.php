<?php

namespace Neuser\Cmsify;

use Baum\Providers\BaumServiceProvider;
use Illuminate\Support\ServiceProvider;

class CmsifyServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method
        $this->app->router->group(
            ['namespace' => 'Neuser\Cmsify\Controllers', 'prefix' => 'cmsify']
            , function ()
        {
            \Route::get('/', function ()
            {
                return view('cmsify');
            });

            \Route::group(['prefix' => 'api'], function ()
            {
                \Route::resource('categories', 'CategoriesController');
            });
        });

        $this->app->register(BaumServiceProvider::class);
    }
}