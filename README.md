![Laravel Vendus](https://raw.githubusercontent.com/CodeTechAgency/laravel-vendus/main/art/banner.png)

# Laravel Vendus

[![Latest version](https://img.shields.io/github/release/CodeTechAgency/laravel-vendus?style=flat-square)](https://github.com/CodeTechAgency/laravel-vendus/releases)
[![Total downloads](https://img.shields.io/packagist/dt/codetech/laravel-vendus?style=flat-square)](https://packagist.org/packages/codetech/laravel-vendus)
[![Tests](https://img.shields.io/github/actions/workflow/status/CodeTechAgency/laravel-vendus/tests.yml?branch=main&style=flat-square&label=tests)](https://github.com/CodeTechAgency/laravel-vendus/actions/workflows/tests.yml)
[![GitHub license](https://img.shields.io/github/license/CodeTechAgency/laravel-vendus?style=flat-square)](https://github.com/CodeTechAgency/laravel-vendus/blob/main/LICENSE.txt)

Connect your Laravel application to [Vendus](https://www.vendus.pt), the Portuguese
certified invoicing software. Keep your Eloquent models — customers and products —
in sync with your Vendus account through a pair of drop-in traits, and build
certified sales documents (invoices, receipts, credit notes) on top of a clean,
fully testable HTTP client.

## Quick start

```bash
composer require codetech/laravel-vendus
```

Set your Vendus API key in `.env`:

```ini
VENDUS_API_KEY=your-api-key
```

Add a `vendus_id` column to the table of any model you want to sync, give the model
the matching trait, and sync it:

```php
use CodeTech\Vendus\Contracts\VendusClient;
use CodeTech\Vendus\Traits\InteractsWithVendusClient;

class Customer extends Model implements VendusClient
{
    use InteractsWithVendusClient;
}
```

```php
use CodeTech\Vendus\VendusResource;

$customer = Customer::find(1);

$resource = new VendusResource($customer);
$resource->sync();
```

`sync()` creates the customer on Vendus (or updates it if it already exists — clients
are matched by their Vendus `external_reference`) and stores the resulting Vendus ID
on your model. Products work the same way with the `InteractsWithVendusProduct` trait
and `VendusProduct` contract, matched by their Vendus product `reference`.

## Documentation

Configuration, customizing the attribute mappings, sales documents, translations —
it's all covered in [the documentation](https://www.codetech.pt/open-source/laravel-vendus).

Upgrading from 1.x? See the [upgrade guide](https://github.com/CodeTechAgency/laravel-vendus/blob/main/UPGRADE.md).

## Changelog

Every release is documented on the [GitHub releases page](https://github.com/CodeTechAgency/laravel-vendus/releases).

## Contributing

Contributions are welcome! Please read the [contributing guidelines](https://github.com/CodeTechAgency/laravel-vendus/blob/main/CONTRIBUTING.md) before opening an issue or pull request.

## Security

If you discover a security vulnerability, please follow the [security policy](https://github.com/CodeTechAgency/laravel-vendus/blob/main/SECURITY.md) — do not report it publicly.

## Support

If this package helps you, consider [starring the repository](https://github.com/CodeTechAgency/laravel-vendus) —
it helps other developers discover it.

---

## License

**codetech/laravel-vendus** is open-sourced software licensed under
the [MIT license](https://github.com/CodeTechAgency/laravel-vendus/blob/main/LICENSE.txt).

## About CodeTech

[CodeTech](https://www.codetech.pt) is a web development agency based in Matosinhos, Portugal. Oh, and we LOVE Laravel!
