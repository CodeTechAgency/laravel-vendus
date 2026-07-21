<?php

use CodeTech\Vendus\Http\VendusApi;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->api = new VendusApi('test-api-key', 'https://www.vendus.test/ws/v1.1/');
});

it('finds a resource by id', function () {
    Http::fake([
        'www.vendus.test/ws/v1.1/clients/123*' => Http::response(['id' => 123, 'name' => 'Maria']),
    ]);

    $client = $this->api->clients()->find(123);

    expect($client)->toBeObject()
        ->and($client->id)->toBe(123)
        ->and($client->name)->toBe('Maria');

    Http::assertSent(function (Request $request) {
        return str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/clients/123')
            && $request['api_key'] === 'test-api-key';
    });
});

it('returns null and records errors when a find fails', function () {
    Http::fake([
        '*' => Http::response([
            'errors' => [['code' => 'A001', 'message' => 'Resource not found']],
        ], 404),
    ]);

    $client = $this->api->clients()->find(999);

    expect($client)->toBeNull()
        ->and($this->api->getErrors())->toBe(['A001: Resource not found']);
});

it('records no errors when a failure response has no json body', function () {
    Http::fake([
        '*' => Http::response('Internal Server Error', 500),
    ]);

    $client = $this->api->clients()->find(1);

    expect($client)->toBeNull()
        ->and($this->api->getErrors())->toBe([]);
});

it('gets a listing of resources with extra query params', function () {
    Http::fake([
        '*' => Http::response([['id' => 1], ['id' => 2]]),
    ]);

    $products = $this->api->products()->get(['status' => 'on']);

    expect($products)->toHaveCount(2)
        ->and($products[0]->id)->toBe(1);

    Http::assertSent(function (Request $request) {
        return str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/products')
            && $request['status'] === 'on'
            && $request['api_key'] === 'test-api-key';
    });
});

it('returns an empty list and records errors when a get fails', function () {
    Http::fake([
        '*' => Http::response([
            'errors' => [['code' => 'A401', 'message' => 'Invalid api key']],
        ], 401),
    ]);

    $products = $this->api->products()->get();

    expect($products)->toBe([])
        ->and($this->api->getErrors())->toBe(['A401: Invalid api key']);
});

it('paginates a listing using the paginator header', function () {
    Http::fake([
        '*' => Http::response([['id' => 1]], 200, ['X-Paginator-Items' => '42']),
    ]);

    $page = $this->api->documents()->paginate([], 2, 10);

    expect($page['total'])->toBe(42)
        ->and($page['data'])->toHaveCount(1);

    Http::assertSent(function (Request $request) {
        return $request['page'] == 2 && $request['per_page'] == 10;
    });
});

it('creates a resource with a form-encoded body', function () {
    Http::fake([
        '*' => Http::response(['id' => 55]),
    ]);

    $result = $this->api->clients()->create(['name' => 'Maria', 'fiscal_id' => '123456789']);

    expect($result->id)->toBe(55);

    Http::assertSent(function (Request $request) {
        return $request->method() === 'POST'
            && $request->isForm()
            && $request['name'] === 'Maria'
            && str_contains($request->url(), 'api_key=test-api-key');
    });
});

it('records errors and rethrows when a create fails', function () {
    Http::fake([
        '*' => Http::response([
            'errors' => [['code' => 'A100', 'message' => 'Missing fiscal id']],
        ], 422),
    ]);

    expect(fn () => $this->api->clients()->create(['name' => 'Maria']))
        ->toThrow(RequestException::class)
        ->and($this->api->getErrors())->toBe(['A100: Missing fiscal id']);
});

it('updates a resource with a patch request', function () {
    Http::fake([
        '*' => Http::response(['id' => 55, 'name' => 'Updated']),
    ]);

    $result = $this->api->clients()->update(55, ['name' => 'Updated']);

    expect($result->name)->toBe('Updated');

    Http::assertSent(function (Request $request) {
        return $request->method() === 'PATCH'
            && str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/clients/55');
    });
});

it('exposes the resource endpoints and their uris', function () {
    Http::fake(['*' => Http::response([])]);

    $this->api->units()->get();
    $this->api->paymentMethods()->get();

    Http::assertSent(fn (Request $request) => str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/products/units'));
    Http::assertSent(fn (Request $request) => str_starts_with($request->url(), 'https://www.vendus.test/ws/v1.1/documents/paymentmethods'));
});
