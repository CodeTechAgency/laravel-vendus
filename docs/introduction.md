---
title: Introduction
weight: 1
group: Getting started
---

[Vendus](https://www.vendus.pt) (Cegid Vendus) is a Portuguese certified invoicing
and POS software. This package connects it to Laravel:

- **Sync Eloquent models** — customers, products — with your Vendus account through
  a pair of drop-in traits. Create, update, or let the package figure out which of
  the two is needed with a single `sync()` call.
- **Issue certified sales documents** — invoices, receipts, credit notes, transport
  guides — through a clean HTTP client, with the document types, item parameters,
  stock types, and tax codes exposed as constants.
- **Translate the domain** — the package ships English and Portuguese strings for
  document types, payment statuses, and sync feedback messages.

Because the HTTP layer is built on Laravel's HTTP client, the entire integration can
be faked in your tests with `Http::fake()` — no real API calls, no mocking gymnastics.

## Architecture

The package is organized in three layers, from your models down to the wire:

- **Contracts** (`VendusApiResource`, `VendusClient`, `VendusProduct`) declare the
  data a syncable model must expose — its Vendus ID, the attribute values, and the
  parameters used to match it against existing Vendus records.
- **Traits** (`InteractsWithVendusClient`, `InteractsWithVendusProduct`) implement
  those contracts with sensible defaults that read conventional column names
  (`name`, `email`, `reference`, `gross_price`, …). Override any getter to map your
  own schema.
- **`VendusResource`** wraps a model implementing a contract and performs the API
  operations — `find`, `get`, `store`, `update`, and `sync` — through the underlying
  **`VendusApi`** client, which exposes the `clients`, `products`, `products/units`,
  `documents`, and `documents/paymentmethods` endpoints.

A typical sync is a handful of lines:

```php
use CodeTech\Vendus\VendusResource;

$customer = Customer::find(1);

$resource = new VendusResource($customer);
$resource->sync();
```

Continue with the [requirements](requirements.md) and
[installation](installation.md), then follow the
[clients](syncing-clients.md) and [products](syncing-products.md) walkthroughs.
