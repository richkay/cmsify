<?php 

namespace Cmsify;

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
            ['namespace' => 'Cmsify\Controllers', 'prefix' => 'cmsify', 'middleware' => 'auth']
            , function ()
        {
            require_once 'routes.php';
        });

        $this->app->register(BaumServiceProvider::class);
    }
}