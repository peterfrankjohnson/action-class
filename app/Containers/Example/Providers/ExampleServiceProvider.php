<?php


namespace App\Containers\Example\Providers;


use App\Containers\Example\Interfaces\Repositories\WidgetRepositoryInterface;
use App\Containers\Example\Repositories\WidgetRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class ExampleServiceProvider extends ServiceProvider
{
    /**
     * Called during the application bootstrap process
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../../../database/migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     *
     */
    public function registerBindings()
    {
        $this->app->bind(
            WidgetRepositoryInterface::class,
            WidgetRepositoryEloquent::class
        );
    }
}