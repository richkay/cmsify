<?php 

namespace Cmsify;

use Baum\Providers\BaumServiceProvider;
use Illuminate\Support\ServiceProvider;

class CmsifyServiceProvider extends ServiceProvider
{
    /**
     * Boots the service provider.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'cmsify');
        
        $this->publishes([
            __DIR__ . '/config.php' => config_path('cmsify.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/assets/js' => public_path('js'),
            __DIR__ . '/assets/css' => public_path('css'),
            // !TODO fontawesome: howto specify the fonts url
            __DIR__ . '/assets/fonts' => public_path('fonts'),
        ], 'public');

        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/cmsify'),
        ], 'views');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'cmsify'
        );

        $this->app->router->group(
            ['namespace' => 'Cmsify\Controllers', 'prefix' => 'cmsify', 'middleware' => 'auth']
            , function ()
        {
            require_once 'routes.php';
        });

        $this->app->bind(Post::class, function() {
            $class = config('cmsify.models.post.class');
            return new $class();
        });

        // composer dependency
        $this->app->register(BaumServiceProvider::class);
    }
}