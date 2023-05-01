# Laravel Vendus

Laravel wrapper for the codetech/vendus-api package.

[![Latest version](https://img.shields.io/github/release/CodeTechAgency/laravel-vendus?style=flat-square)](https://github.com/CodeTechAgency/laravel-vendus/releases)
[![GitHub license](https://img.shields.io/github/license/CodeTechAgency/laravel-vendus?style=flat-square)](https://github.com/CodeTechAgency/laravel-vendus/blob/master/LICENSE)


## Installation

Install the PHP dependency
```
composer require codetech/laravel-vendus
```

Publish the configuration file (optional)
```
php artisan vendor:publish --provider=CodeTech\\Vendus\\Providers\\VendusServiceProvider --tag=config
```

For setting up the API key, add this line to your `.env` file:
```
VENDUS_API_KEY=
``` 

Cache the configurations
```
php artisan config:cache
```


## Translations

This package comes with some translations available that you can use to present messages of results of operations, etc.

Publish the translations file (optional)

```
php artisan vendor:publish --provider=CodeTech\\Vendus\\Providers\\VendusServiceProvider --tag=translations
```

---

## License

**codetech/laravel-vendus** is open-sourced software licensed under the [MIT license](https://github.com/CodeTechAgency/laravel-vendus/blob/master/LICENSE).


## About CodeTech

[CodeTech](https://www.codetech.pt) is a web development agency based in Matosinhos, Portugal. Oh, and we LOVE Laravel!
