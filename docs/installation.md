---
title: Installation
weight: 3
group: Getting started
---

Add the package to your Laravel application using Composer:

```bash
composer require codetech/laravel-vendus
```

The service provider is registered automatically through Laravel's package
discovery — there is nothing to add to your application.

Set your API key in `.env` and you are ready to go:

```ini
VENDUS_API_KEY=your-api-key
```

All settings — and the optional publishing of the config file and translations —
are covered in [Configuration](configuration.md).
