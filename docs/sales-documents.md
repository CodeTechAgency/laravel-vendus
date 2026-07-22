---
title: Sales documents
weight: 7
group: Usage
---

Sales documents — invoices, receipts, credit notes, transport guides — are issued
through the `VendusApi` client directly. Unlike clients and products, documents
are immutable certified records, so there is no trait or sync flow: you build the
payload and create the document.

```php
use CodeTech\Vendus\Entities\VendusSalesDocument;
use CodeTech\Vendus\Http\VendusApi;

$api = new VendusApi(config('vendus.api_key'));

$document = $api->documents()->create([
    'type' => VendusSalesDocument::TYPE_FT,
    'mode' => config('vendus.mode'),
    'client' => [
        'id' => $customer->getVendusId(),
    ],
    'items' => [
        [
            'id' => $product->getVendusId(),
            'qty' => 2,
        ],
    ],
    'output' => VendusSalesDocument::OUTPUT_PDF,
]);
```

Keep `mode` bound to [the config value](configuration.md#mode) — `tests` creates
draft documents that are neither certified nor communicated to the tax authority,
`normal` creates the real thing.

Besides `documents()`, the client exposes the `clients()`, `products()`,
`units()`, and `paymentMethods()` endpoints, each with `find`, `get`, `paginate`,
`create`, and `update` methods.

## Document types

The `VendusSalesDocument` constants cover the Vendus document types:

| Constant  | Value | Document                                        |
|-----------|-------|-------------------------------------------------|
| `TYPE_FT` | `FT`  | Fatura — invoice                                |
| `TYPE_FS` | `FS`  | Fatura Simplificada — simplified invoice        |
| `TYPE_FR` | `FR`  | Fatura-Recibo — invoice/receipt                 |
| `TYPE_NC` | `NC`  | Nota de Crédito — credit note                   |
| `TYPE_RG` | `RG`  | Recibo — receipt                                |
| `TYPE_PF` | `PF`  | Fatura Pró-Forma — proforma invoice             |
| `TYPE_OT` | `OT`  | Orçamento — quotation                           |
| `TYPE_EC` | `EC`  | Encomenda — customer order                      |
| `TYPE_DC` | `DC`  | Consulta de Mesa — table check (POS)            |
| `TYPE_GT` | `GT`  | Guia de Transporte — transport guide            |
| `TYPE_GR` | `GR`  | Guia de Remessa — shipping guide                |
| `TYPE_GD` | `GD`  | Guia de Devolução — return guide                |
| `TYPE_GA` | `GA`  | Guia de Ativos Próprios — own assets guide      |

## Output formats

Ask Vendus to render the document by passing `output`:

| Constant        | Value    | Result                          |
|-----------------|----------|---------------------------------|
| `OUTPUT_PDF`    | `pdf`    | PDF document                    |
| `OUTPUT_ESCPOS` | `escpos` | ESC/POS payload for printers    |
| `OUTPUT_HTML`   | `html`   | HTML document                   |

## Allowed parameters

`VendusSalesDocument::CREATE_ALLOWED_PARAMS` lists every parameter the documents
endpoint accepts on creation — `register_id`, `payments`, `date_due`,
`movement_of_goods`, `invoices`, and so on — and
`VendusItem::CREATE_ALLOWED_PARAMS` does the same for each entry of `items`
(`qty`, `gross_price`, `discount_percentage`, `tax_id`, …). Use them to whitelist
user-provided input before it reaches the API:

```php
use CodeTech\Vendus\Entities\VendusSalesDocument;
use Illuminate\Support\Arr;

$params = Arr::only($input, VendusSalesDocument::CREATE_ALLOWED_PARAMS);
```

## Reading documents

`get()` lists documents with any filter the API accepts, and `find()` fetches a
single one — including its rendered output:

```php
$invoices = $api->documents()->get(['type' => VendusSalesDocument::TYPE_FT]);

$document = $api->documents()->find($id, ['output' => VendusSalesDocument::OUTPUT_PDF]);
```

For large listings, `paginate()` returns a page of results plus the total count
reported by the API:

```php
['data' => $documents, 'total' => $total] = $api->documents()->paginate([], page: 1, perPage: 50);
```

## Error handling

Failed creates throw an `Illuminate\Http\Client\RequestException`; the parsed
Vendus error messages are available on the client:

```php
try {
    $api->documents()->create($params);
} catch (RequestException $e) {
    $errors = $api->getErrors(); // ['field' => 'code: message', …]
}
```
