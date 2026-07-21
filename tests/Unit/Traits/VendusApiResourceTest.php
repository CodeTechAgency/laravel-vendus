<?php

use CodeTech\Vendus\Tests\Fixtures\Client;

it('reads the vendus id from the model', function () {
    expect((new Client)->getVendusId())->toBeNull()
        ->and((new Client(['vendus_id' => 42]))->getVendusId())->toBe(42);
});

it('persists the vendus id when set', function () {
    $client = Client::create(['name' => 'Maria']);

    $client->setVendusId(42);

    expect($client->fresh()->vendus_id)->toBe(42);
});

it('builds the detail page link from the configured app url', function () {
    $client = new Client(['vendus_id' => 5]);

    expect($client->getDetailPageLink())->toBe('https://vendus.test/clients/detail/id/5');
});
