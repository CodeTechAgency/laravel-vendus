# Contributing

Thanks for considering contributing to **codetech/laravel-vendus**!

## Which branch?

- **New features and improvements**: target the [`main`](https://github.com/CodeTechAgency/laravel-vendus/tree/main) branch (2.x, Laravel 11–13).
- **Security fixes for the 1.x line** (Laravel 6–10): open an issue first — 1.x receives security fixes only, released from the latest `v1.1.x` tag. No other changes are accepted there.

## Getting started

```bash
git clone git@github.com:CodeTechAgency/laravel-vendus.git
cd laravel-vendus
composer install
```

## Running the package locally

The repository ships a `testbench.yaml`, so the [Testbench CLI](https://packages.tools/testbench) can boot the package inside a real Laravel skeleton without creating a host application:

```bash
cp .env.example .env      # then add your Vendus API key
vendor/bin/testbench tinker
```

Inside tinker the container is up and the service provider is registered, so calls hit the real Vendus API with the credentials from `.env` — e.g.:

```php
(new CodeTech\Vendus\Http\VendusApi(config('vendus.api_key')))->clients()->get()
```

## Before submitting a pull request

Run the full quality suite locally — CI runs the same checks:

```bash
composer test      # Pest test suite
composer lint      # Pint code-style check (run `composer format` to fix)
composer analyse   # PHPStan static analysis
```

- Add tests for any change in behaviour. Tests are written with Pest — unit tests live in `tests/Unit`, feature tests in `tests/Feature`.
- Keep pull requests focused: one feature or fix per PR.
- Use a [conventional-commit](https://www.conventionalcommits.org) style title, e.g. `fix(product): handle missing barcode`.
- Reference the related issue in the PR description. If there is no issue yet, please open one first so the change can be discussed.

## Reporting bugs

Open an issue using the bug report template and include the package, Laravel and PHP versions plus the smallest reproduction you can manage.

**Security vulnerabilities must not be reported publicly** — see the [security policy](https://github.com/CodeTechAgency/laravel-vendus/blob/main/SECURITY.md).
