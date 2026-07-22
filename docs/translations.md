---
title: Translations
weight: 8
group: Usage
---

The package ships translation strings for the Vendus domain — document types,
payment statuses, and sync feedback messages — in English and Portuguese, under
the `vendus::messages` namespace:

```php
__('vendus::messages.record_synced_success');
// en: The record has been successfully synced with Vendus!
// pt: O recurso foi sincronizado com o Vendus com sucesso!
```

Plural forms use Laravel's standard pluralization:

```php
trans_choice('vendus::messages.payments', 2);
// en: Payments — pt: Pagamentos
```

## Available strings

- **Document types** — `ft` (Invoice), `fr` (Invoice Receipt), `rg` (Receipt),
  `pf` (Proforma Invoice), `ot` (Quotation). Handy for labelling documents by
  their type code: `__('vendus::messages.'.strtolower($document['type']))`.
- **Payment status** — `paid`, `not_paid`.
- **Sync feedback** — `record_created_success`, `record_updated_success`,
  `record_deleted_success`, `record_synced_success`, `not_yet_synced`.
- **UI labels** — `vendus`, `synchronize`, `payments`, `sales_documents`,
  `related_documents`, `related_record_confirm_create`.

## Customizing

Publish the language files to override any string or add locales:

```bash
php artisan vendor:publish --provider="CodeTech\Vendus\Providers\VendusServiceProvider" --tag=translations
```

The files land in `lang/vendor/vendus/{locale}/messages.php`, and Laravel gives
them precedence over the package's own copies.
