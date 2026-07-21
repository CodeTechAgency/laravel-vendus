<?php

namespace CodeTech\Vendus\Tests;

use CodeTech\Vendus\Providers\VendusServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        $app['config']->set('vendus.base_url', 'https://www.vendus.test/ws/v1.1/');
    }

    protected function defineDatabaseMigrations(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendus_id')->nullable();
            $table->string('fiscal_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->json('price_group')->nullable();
            $table->string('send_mail')->nullable();
            $table->string('irs_retention')->nullable();
            $table->string('status')->nullable();
            $table->string('notes')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendus_id')->nullable();
            $table->string('reference')->nullable();
            $table->string('barcode')->nullable();
            $table->string('supplier_code')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('include_description')->nullable();
            $table->string('supply_price')->nullable();
            $table->string('gross_price')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('type_id')->nullable();
            $table->unsignedInteger('stock_control')->nullable();
            $table->string('stock_type')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('tax_exemption')->nullable();
            $table->string('tax_exemption_law')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->nullable();
            $table->json('prices')->nullable();
            $table->timestamps();
        });
    }
}
