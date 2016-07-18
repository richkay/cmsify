<?php

namespace Neuser\Cmsify;

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
            ['namespace' => 'Neuser\Cmsify\Http\Controllers', 'prefix' => 'cmsify']
            , function ()
        {
            \Route::get('/', function() {
                return view('cmsify');
            });

        });
    }
}