<?php

namespace Zhineng\NovaGatekeeper;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Zhineng\NovaGatekeeper\Http\Middleware\Authorize;
use Zhineng\NovaGatekeeper\Resources\Permission;
use Zhineng\NovaGatekeeper\Resources\Role;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-gatekeeper');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nova-gatekeeper');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            $this->resources();
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-gatekeeper')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function resources(): void
    {
        Nova::resources(NovaGatekeeper::resources());
    }
}
