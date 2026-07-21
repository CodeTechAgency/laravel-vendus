<?php

use CodeTech\Vendus\Tests\Fixtures\Client;

it('maps model attributes to vendus client params', function () {
    $client = new Client([
        'fiscal_id' => '123456789',
        'name' => 'Maria Silva',
        'address' => 'Rua das Flores 1',
        'city' => 'Porto',
        'postal_code' => '4000-001',
        'phone' => '220000000',
        'mobile' => '910000000',
        'email' => 'maria@example.com',
        'website' => 'https://example.com',
        'country' => 'PT',
        'price_group' => ['id' => 1],
        'send_mail' => 'yes',
        'irs_retention' => 'no',
        'status' => 'active',
        'notes' => 'VIP',
    ]);
    $client->id = 7;

    expect($client->getVendusParams())->toEqual([
        'fiscal_id' => '123456789',
        'external_reference' => '7',
        'name' => 'Maria Silva',
        'address' => 'Rua das Flores 1',
        'city' => 'Porto',
        'postalcode' => '4000-001',
        'phone' => '220000000',
        'mobile' => '910000000',
        'email' => 'maria@example.com',
        'website' => 'https://example.com',
        'country' => 'PT',
        'price_group' => ['id' => 1],
        'send_email' => 'yes',
        'irs_retention' => 'no',
        'status' => 'active',
        'notes' => 'VIP',
    ]);
});

it('applies sensible defaults for missing client attributes', function () {
    $params = (new Client)->getVendusParams();

    expect($params['status'])->toBe('active')
        ->and($params['send_email'])->toBe('no')
        ->and($params['price_group'])->toBe([])
        ->and($params['name'])->toBe('');
});

it('matches existing vendus clients by external reference', function () {
    $client = new Client;
    $client->id = 7;

    expect($client->getVendusFindMatchParams())->toBe(['external_reference' => '7']);
});

it('uses the clients resource name', function () {
    expect((new Client)->getVendusResourceName())->toBe('clients');
});
