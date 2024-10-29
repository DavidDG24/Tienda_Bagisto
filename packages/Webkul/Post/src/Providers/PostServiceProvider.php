<?php

namespace Webkul\Post\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Post\Providers\EventServiceProvider;
use Webkul\Post\Console\Commands\PublishFacebookVideos;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Routes/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'post');
        
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'post');

            // Publicar los archivos CSS y JS en la carpeta public
        $this->publishes([
            __DIR__ . '/../Resources/assets/js/custom.js' => public_path('vendor/post/js/custom.js'),
            __DIR__ . '/../Resources/assets/css/custom.css' => public_path('vendor/post/css/custom.css'),
        ], 'public');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishFacebookVideos::class,
            ]);
        }

          // Usar `composer` para cargar los assets solo en la vista específica
        $this->app['view']->composer('post::admin.facebook-video', function ($view) {
            $view->with('cssPath', asset('vendor/post/css/fbvideo.css'));
            $view->with('jsPath', asset('vendor/post/js/fbvideo.js'));
        });

            Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('post::admin.layouts.style');
        });
        Event::listen('catalog.product.update.after', 'Webkul\Post\Listeners\PublicarFacebook@handle');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
    }
}