<?php

use CodeTech\Vendus\Providers\VendusServiceProvider;
use Illuminate\Support\ServiceProvider;

it('merges the package configuration', function () {
    expect(config('vendus'))->toHaveKeys(['mode', 'api_key', 'app_url'])
        ->and(config('vendus.api_key'))->toBe('test-api-key')
        ->and(config('vendus.mode'))->toBe('tests');
});

it('loads the vendus translation namespace', function () {
    expect(trans('vendus::messages.ft'))->toBe('Invoice')
        ->and(trans('vendus::messages.ft', [], 'pt'))->toBe('Fatura');
});

it('publishes the config file', function () {
    $paths = ServiceProvider::pathsToPublish(VendusServiceProvider::class, 'config');

    expect($paths)->toContain(config_path('vendus.php'));
});

it('publishes the translations', function () {
    $paths = ServiceProvider::pathsToPublish(VendusServiceProvider::class, 'translations');

    expect($paths)->toContain(app()->langPath('vendor/vendus'));
});
