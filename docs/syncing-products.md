---
title: Syncing products
weight: 6
group: Usage
---

Products follow the exact same pattern as [clients](syncing-clients.md): a
`vendus_id` column, the `VendusProduct` contract, and the
`InteractsWithVendusProduct` trait.

```php
use CodeTech\Vendus\Contracts\VendusProduct;
use CodeTech\Vendus\Traits\InteractsWithVendusProduct;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements VendusProduct
{
    use InteractsWithVendusProduct;
}
```

```php
use CodeTech\Vendus\VendusResource;

(new VendusResource($product))->sync();
```

## Attribute mapping

| Getter                         | Reads                     | Sent as             | Default              |
|--------------------------------|---------------------------|---------------------|----------------------|
| `getVendusReference()`         | `$this->reference`        | `reference`         | `''`                 |
| `getVendusBarcode()`           | `$this->barcode`          | `barcode`           | `''`                 |
| `getVendusSupplierCode()`      | `$this->supplier_code`    | `supplier_code`     | `''`                 |
| `getVendusTitle()`             | `$this->title`            | `title`             | `''`                 |
| `getVendusDescription()`       | `$this->description`      | `description`       | `''`                 |
| `getVendusIncludeDescription()`| `$this->include_description` | `include_description` | `'no'`          |
| `getVendusSupplyPrice()`       | `$this->supply_price`     | `supply_price`      | `0`                  |
| `getVendusGrossPrice()`        | `$this->gross_price`      | `gross_price`       | `0`                  |
| `getVendusUnitId()`            | `$this->unit_id`          | `unit_id`           | `null`               |
| `getVendusTypeId()`            | `$this->type_id`          | `type_id`           | `'P'`                |
| `getVendusStockControl()`      | `$this->stock_control`    | `stock_control`     | `0`                  |
| `getVendusStockType()`         | `$this->stock_type`       | `stock_type`        | `VendusStock::TYPE_T`|
| `getVendusTaxId()`             | `$this->tax_id`           | `tax_id`            | `''`                 |
| `getVendusTaxExemption()`      | `$this->tax_exemption`    | `tax_exemption`     | `''`                 |
| `getVendusTaxExemptionLaw()`   | `$this->tax_exemption_law`| `tax_exemption_law` | `''`                 |
| `getVendusCategoryId()`        | `$this->category_id`      | `category_id`       | `null`               |
| `getVendusBrandId()`           | `$this->brand_id`         | `brand_id`          | `null`               |
| `getVendusImage()`             | `$this->image`            | `image`             | `''`                 |
| `getVendusStatus()`            | `$this->status`           | `status`            | `'on'`               |
| `getVendusPrices()`            | `$this->prices`           | `prices`            | `[]`                 |

As with clients, override any getter to map your own schema.

## Matching existing products

When a model has no `vendus_id`, `sync()` first looks for an existing Vendus
product before creating one. By default the lookup searches by `reference` using
the model's ID (its external reference):

```php
public function getVendusFindMatchParams(): array
{
    return [
        'reference' => $this->getVendusExternalReference(),
    ];
}
```

If your `reference` column holds something other than the model's ID, override
`getVendusFindMatchParams()` so the match uses the same value you send:

```php
public function getVendusFindMatchParams(): array
{
    return [
        'reference' => $this->getVendusReference(),
    ];
}
```

## Product types

`type_id` classifies the product for SAF-T purposes:

| Value | Meaning                                                  |
|-------|----------------------------------------------------------|
| `P`   | Product (default)                                        |
| `S`   | Service                                                  |
| `O`   | Other — shipping, advances, etc.                         |
| `I`   | Tax other than VAT and stamp duty, or parafiscal charge  |
| `E`   | Special consumption tax — IABA, ISP, IT                  |

## Stock types

The `CodeTech\Vendus\Entities\VendusStock` constants cover the allowed
`stock_type` values:

| Constant             | Value | Meaning                                       |
|----------------------|-------|-----------------------------------------------|
| `VendusStock::TYPE_M`| `M`   | Merchandise                                   |
| `VendusStock::TYPE_P`| `P`   | Raw, subsidiary, and consumable materials     |
| `VendusStock::TYPE_A`| `A`   | Finished and intermediate products            |
| `VendusStock::TYPE_S`| `S`   | By-products, waste, and scrap                 |
| `VendusStock::TYPE_T`| `T`   | Products and work in progress (default)       |

## Tax codes

The `CodeTech\Vendus\Entities\VendusTax` constants cover the Portuguese VAT
classes accepted in `tax_id`:

| Constant              | Value  | Meaning                                          |
|-----------------------|--------|--------------------------------------------------|
| `VendusTax::TAX_NOR`  | `NOR`  | Normal rate                                      |
| `VendusTax::TAX_INT`  | `INT`  | Intermediate rate                                |
| `VendusTax::TAX_RED`  | `RED`  | Reduced rate                                     |
| `VendusTax::TAX_ISE`  | `ISE`  | Exempt — requires `tax_exemption` and `tax_exemption_law` |
| `VendusTax::TAX_OUT`  | `OUT`  | Other                                            |
