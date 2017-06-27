<?php

namespace Apiauth\Laravel;

use Illuminate\Support\ServiceProvider;
use Apiauth\Laravel\Middleware\CheckAuth;

class CAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([
            realpath(__DIR__.'/../config/apiauth.php') => config_path('apiauth.php'),
        ]);

        $router->aliasMiddleware('apiauth', 'Apiauth\Laravel\Middleware\CheckAuth');
    }
}
