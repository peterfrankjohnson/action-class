<?php


namespace Tests;


use App\Containers\Example\Providers\ExampleServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing']);
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('app.debug', env('APP_DEBUG', true));
    }

    protected function getPackageProviders($app)
    {
        return [
            ExampleServiceProvider::class,
        ];
    }
}