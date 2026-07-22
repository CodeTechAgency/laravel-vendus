---
title: Configuration
weight: 4
group: Getting started
---

The package is configured through environment variables (see `config/vendus.php`):

```ini
VENDUS_API_KEY=your-api-key
VENDUS_APP_URL=https://www.vendus.pt
VENDUS_MODE=tests
VENDUS_BASE_URL=https://www.vendus.pt/ws/v1.1/
```

## API key

`VENDUS_API_KEY` is the only required setting — every request against the Vendus
API is authenticated with it. You can find it in the Vendus backoffice under your
account's integration settings. If it is missing, `VendusResource` fails loudly
with an `InvalidArgumentException` instead of firing unauthenticated requests.

## App URL

`VENDUS_APP_URL` is the URL you use to access the Vendus web application. It is
only used by `getDetailPageLink()` to build links from your application straight
to a synced record's detail page in the Vendus backoffice:

```php
$customer->getDetailPageLink();
// https://www.vendus.pt/clients/detail/id/123
```

## Mode

Vendus can register sales documents in two modes: `normal` (real, certified
documents) and `tests` (draft documents that are not certified nor communicated
to the tax authority). The config value — `tests` by default, so a fresh install
can never issue real invoices by accident — is yours to pass when
[creating documents](sales-documents.md):

```php
'mode' => config('vendus.mode'),
```

Set `VENDUS_MODE=normal` in production.

## Base URL

`VENDUS_BASE_URL` points at Vendus API v1.1 by default. You will rarely need to
change it — it exists so the client can be pointed at a different API version or
host without touching code.

## Publishing the config file

To tweak the configuration beyond what the environment variables cover, publish
the config file:

```bash
php artisan vendor:publish --provider="CodeTech\Vendus\Providers\VendusServiceProvider" --tag=config
```

The package also ships [translations](translations.md), publishable with the
`translations` tag.
