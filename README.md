# Laravel Vendus

Laravel wrapper for the waap/vendus-api package.


## Installation

Install the PHP dependency
```
composer require waap/laravel-vendus
```

Publish the configuration file (optional)
```
php artisan vendor:publish --provider=Waap\\Vendus\\Providers\\VendusServiceProvider --tag=config
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
php artisan vendor:publish --provider=Waap\\Vendus\\Providers\\VendusServiceProvider --tag=translations
```

---

## License

**waap/laravel-vendus** is open-sourced software licensed under the [MIT license](https://github.com/waap-agency/laravel-vendus/blob/master/LICENSE).


## About waap

[waap](https://www.waap.pt) is a web development agency based in Matosinhos, Portugal. Oh, and we LOVE Laravel!
