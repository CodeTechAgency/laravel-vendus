<?php

namespace CodeTech\Vendus\Tests;

use CodeTech\Vendus\Providers\VendusServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            VendusServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode('vendus-testing-key-32-bytes-long'));

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('vendus.api_key', 'test-api-key');
        $app['config']->set('vendus.app_url', 'https://vendus.test');
    }
}
