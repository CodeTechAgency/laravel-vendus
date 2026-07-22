---
title: Syncing clients
weight: 5
group: Usage
---

Any Eloquent model can be synced with Vendus' `clients` resource — a `Customer`,
a `Company`, a `User`. The model needs three things: a `vendus_id` column, the
`VendusClient` contract, and the `InteractsWithVendusClient` trait.

## Prepare the model

Add the column that will store the Vendus ID:

```php
Schema::table('customers', function (Blueprint $table) {
    $table->unsignedBigInteger('vendus_id')->nullable();
});
```

Then implement the contract using the trait:

```php
use CodeTech\Vendus\Contracts\VendusClient;
use CodeTech\Vendus\Traits\InteractsWithVendusClient;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements VendusClient
{
    use InteractsWithVendusClient;
}
```

## Attribute mapping

The trait satisfies the contract by reading conventional column names. Each value
is exposed through a getter, and the full payload sent to Vendus is assembled by
`getVendusParams()`:

| Getter                        | Reads                | Sent as              | Default    |
|-------------------------------|----------------------|----------------------|------------|
| `getVendusFiscalId()`         | `$this->fiscal_id`   | `fiscal_id`          | `''`       |
| `getVendusExternalReference()`| `$this->id`          | `external_reference` | `''`       |
| `getVendusName()`             | `$this->name`        | `name`               | `''`       |
| `getVendusAddress()`          | `$this->address`     | `address`            | `''`       |
| `getVendusCity()`             | `$this->city`        | `city`               | `''`       |
| `getVendusPostalCode()`       | `$this->postal_code` | `postalcode`         | `''`       |
| `getVendusPhone()`            | `$this->phone`       | `phone`              | `''`       |
| `getVendusMobile()`           | `$this->mobile`      | `mobile`             | `''`       |
| `getVendusEmail()`            | `$this->email`       | `email`              | `''`       |
| `getVendusWebsite()`          | `$this->website`     | `website`            | `''`       |
| `getVendusCountry()`          | `$this->country`     | `country`            | `''`       |
| `getVendusPriceGroup()`       | `$this->price_group` | `price_group`        | `[]`       |
| `getVendusSendMail()`         | `$this->send_mail`   | `send_email`         | `'no'`     |
| `getVendusIrsRetention()`     | `$this->irs_retention` | `irs_retention`    | `''`       |
| `getVendusStatus()`           | `$this->status`      | `status`             | `'active'` |
| `getVendusNotes()`            | `$this->notes`       | `notes`              | `''`       |

If your schema uses different names, override the getter — the trait's
`getVendusParams()` picks the change up automatically:

```php
public function getVendusFiscalId(): string
{
    return $this->nif ?? '';
}
```

## Syncing

Wrap the model in a `VendusResource` and call `sync()`:

```php
use CodeTech\Vendus\VendusResource;

(new VendusResource($customer))->sync();
```

`sync()` decides what to do based on the local `vendus_id`:

- **No `vendus_id` yet** — the package first searches Vendus for a client whose
  `external_reference` matches the model's ID (see `getVendusFindMatchParams()`).
  If one exists, its ID is adopted and the record is updated; otherwise the client
  is created. Either way, the resulting Vendus ID is saved on your model.
- **`vendus_id` present** — the Vendus record is updated with the current
  attribute values.

You can also call `store()` or `update()` directly when you know which operation
you want.

## Reading from Vendus

The same `VendusResource` reads back from the API — `find()` fetches the wrapped
model's Vendus record, `get()` lists clients with any filter the API accepts:

```php
$resource = new VendusResource($customer);

$vendusClient = $resource->find([]);
$matches = $resource->get(['fiscal_id' => '123456789']);
```

## Error handling

When Vendus rejects a create or update, an
`Illuminate\Http\Client\RequestException` is thrown and the API's error messages
are collected for inspection:

```php
try {
    (new VendusResource($customer))->sync();
} catch (RequestException $e) {
    $errors = $resource->getErrors(); // ['field' => 'code: message', …]
}
```

## Linking to the Vendus backoffice

Once synced, `getDetailPageLink()` returns the record's detail page URL in the
Vendus web app — handy for back-office UIs:

```php
<a href="{{ $customer->getDetailPageLink() }}">{{ __('vendus::messages.vendus') }}</a>
```
