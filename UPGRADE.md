# Upgrade Guide

## Upgrading from 1.x to 2.0

### New requirements

| | 1.x | 2.x |
|---|---|---|
| PHP | ≥ 7.3 | ≥ 8.2 (≥ 8.3 for Laravel 13) |
| Laravel | 6 – 10 | 11 / 12 / 13 |

Update the requirement in your `composer.json`:

```
"codetech/laravel-vendus": "^2.0"
```

If your application is still on Laravel 10 or older, stay on `^1.1` — the 1.x line receives security fixes only.

### The `codetech/vendus-api` dependency was removed

The HTTP layer now lives inside this package (`CodeTech\Vendus\Http\VendusApi`), built on Laravel's HTTP client. Nothing changes if you only interacted with Vendus through `VendusResource` and the traits — the public API is untouched.

You are affected only if you used the client package directly:

- Code type-hinting, instantiating or extending `CodeTech\VendusApi\Api` / `CodeTech\VendusApi\Endpoint` must migrate to `CodeTech\Vendus\Http\VendusApi` / `CodeTech\Vendus\Http\Endpoint`. The endpoint surface is the same (`clients()`, `products()`, `units()`, `documents()`, `paymentMethods()`, each with `find` / `get` / `paginate` / `create` / `update`).
- If `codetech/vendus-api` sits in your own `composer.json`, remove it — the package is deprecated.

Because requests now go through Laravel's HTTP client, you can fake the entire Vendus integration in your tests with `Http::fake()`.

### New `base_url` config key

The Vendus API base URL is now configurable (in 1.x it was fixed inside the client). It defaults to `https://www.vendus.pt/ws/v1.1/`; override it with the `VENDUS_BASE_URL` environment variable. If you previously published `config/vendus.php`, republish it (or add the key manually):

```
php artisan vendor:publish --provider="CodeTech\Vendus\Providers\VendusServiceProvider" --tag=config --force
```

### A missing API key now fails loudly

Constructing a `VendusResource` without `vendus.api_key` configured throws an `InvalidArgumentException` with a clear message. In 1.x this produced an opaque `TypeError`.

### `VendusResource::find()` works now

In every 1.x release, `find()` was fatally broken (it accessed the endpoint as a property instead of calling it). If you had code paths avoiding `find()` because of that, they can use it now.

### Connection failures throw `ConnectionException`

Transport-level failures (DNS, timeouts, refused connections) now surface as `Illuminate\Http\Client\ConnectionException`. HTTP error responses keep the 1.x behavior: recorded in `getErrors()`, with `create`/`update` rethrowing and `find`/`get` returning `null`/`[]`.

### Stricter signatures

`VendusResource::getErrors()` now declares an `: array` return type. If you extended `VendusResource` and overrode it, update your override to match.

### Translations publish to the Laravel 9+ location

Published translations now land in `lang/vendor/vendus` (via `$app->langPath()`) instead of `resources/lang/vendor/vendus`. If you published them under the old path, move your customized files to the new location.
