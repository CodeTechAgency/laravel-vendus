<?php

use CodeTech\Vendus\Contracts\VendusApiResource;
use CodeTech\Vendus\Tests\Fixtures\Client;
use CodeTech\Vendus\VendusResource;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

function fakeVendusApiResource(): VendusApiResource
{
    return new class implements VendusApiResource
    {
        public function getVendusId(): ?int
        {
            return null;
        }

        public function setVendusId(int $vendusId): void
        {
        }

        public function getVendusResourceName(): string
        {
            return 'clients';
        }

        public function getVendusParams(): array
        {
            return [];
        }

        public function getVendusFindMatchParams(): array
        {
            return [];
        }
    };
}

it('throws a clear exception when the api key is not configured', function () {
    config()->set('vendus.api_key', null);

    new VendusResource(fakeVendusApiResource());
})->throws(InvalidArgumentException::class, 'The Vendus API key is not configured.');

it('throws a clear exception when the api key is an empty string', function () {
    config()->set('vendus.api_key', '');

    new VendusResource(fakeVendusApiResource());
})->throws(InvalidArgumentException::class);

it('stores a new resource on vendus and links it locally', function () {
    Http::fake(function (Request $request) {
        return $request->method() === 'GET'
            ? Http::response([])
            : Http::response(['id' => 987, 'name' => 'Maria']);
    });

    $client = Client::create(['name' => 'Maria', 'fiscal_id' => '123456789']);

    $result = (new VendusResource($client))->store();

    expect($result)->toBe(['id' => 987, 'name' => 'Maria'])
        ->and($client->fresh()->vendus_id)->toBe(987);

    Http::assertSent(function (Request $request) use ($client) {
        return $request->method() === 'GET'
            && $request['external_reference'] == $client->id;
    });
    Http::assertSent(function (Request $request) {
        return $request->method() === 'POST'
            && str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/clients')
            && $request['name'] === 'Maria';
    });
});

it('links and updates when the resource already exists on vendus', function () {
    Http::fake(function (Request $request) {
        return $request->method() === 'GET'
            ? Http::response([['id' => 555]])
            : Http::response(['id' => 555, 'name' => 'Maria']);
    });

    $client = Client::create(['name' => 'Maria']);

    $result = (new VendusResource($client))->store();

    expect($result['id'])->toBe(555)
        ->and($client->fresh()->vendus_id)->toBe(555);

    Http::assertSent(function (Request $request) {
        return $request->method() === 'PATCH'
            && str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/clients/555');
    });
    Http::assertNotSent(fn (Request $request) => $request->method() === 'POST');
});

it('syncs by storing when the model has no vendus id', function () {
    Http::fake(function (Request $request) {
        return $request->method() === 'GET'
            ? Http::response([])
            : Http::response(['id' => 987]);
    });

    $client = Client::create(['name' => 'Maria']);

    (new VendusResource($client))->sync();

    expect($client->fresh()->vendus_id)->toBe(987);
    Http::assertSent(fn (Request $request) => $request->method() === 'POST');
});

it('syncs by updating when the model already has a vendus id', function () {
    Http::fake(['*' => Http::response(['id' => 321, 'name' => 'Updated'])]);

    $client = Client::create(['name' => 'Maria', 'vendus_id' => 321]);

    $result = (new VendusResource($client))->sync();

    expect($result)->toBe(['id' => 321, 'name' => 'Updated']);

    Http::assertSent(function (Request $request) {
        return $request->method() === 'PATCH'
            && str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/clients/321');
    });
    Http::assertNotSent(fn (Request $request) => $request->method() === 'POST');
});

it('propagates creation errors and keeps the model unlinked', function () {
    Http::fake(function (Request $request) {
        return $request->method() === 'GET'
            ? Http::response([])
            : Http::response(['errors' => [['code' => 'A100', 'message' => 'Missing fiscal id']]], 422);
    });

    $client = Client::create(['name' => 'Maria']);
    $resource = new VendusResource($client);

    expect(fn () => $resource->store())->toThrow(RequestException::class)
        ->and($resource->getErrors())->toBe(['A100: Missing fiscal id'])
        ->and($client->fresh()->vendus_id)->toBeNull();
});

it('finds the linked resource on vendus', function () {
    Http::fake(['*' => Http::response(['id' => 5, 'name' => 'Maria'])]);

    $client = Client::create(['name' => 'Maria', 'vendus_id' => 5]);

    $found = (new VendusResource($client))->find([]);

    expect($found->id)->toBe(5);

    Http::assertSent(fn (Request $request) => str_starts_with(
        $request->url(),
        'https://www.vendus.test/ws/v1.1/clients/5'
    ));
});

it('gets a listing of the resource from vendus', function () {
    Http::fake(['*' => Http::response([['id' => 1], ['id' => 2]])]);

    $client = Client::create(['name' => 'Maria']);

    $results = (new VendusResource($client))->get(['status' => 'active']);

    expect($results)->toHaveCount(2);

    Http::assertSent(fn (Request $request) => $request['status'] === 'active');
});
