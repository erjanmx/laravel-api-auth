[![Build Status](https://travis-ci.org/erjanmx/laravel-api-auth.svg?branch=master)](https://travis-ci.org/erjanmx/laravel-api-auth)
[![Latest Stable Version](https://poser.pugx.org/erjanmx/laravel-api-auth/v/stable)](https://packagist.org/packages/erjanmx/laravel-api-auth) 
[![Total Downloads](https://poser.pugx.org/erjanmx/laravel-api-auth/downloads)](https://packagist.org/packages/erjanmx/laravel-api-auth)

# Laravel Api Auth

Laravel gives easy ways to handle api authorization using user based tokens, but sometimes you need to use a single token to give access to your application, especially when you're developing two apps that need to be connected.

Laravel-api-auth makes that easy as breathe, no migrations, no models

### Installing package

```bash
$ composer require erjanmx/laravel-api-auth
```

Configure the Service Provider

```php
// /config/app.php

'providers' => [
    Apiauth\Laravel\CAuthServiceProvider::class
],

```

Publish the Package configuration

```bash
$ php artisan vendor:publish --provider="Apiauth\Laravel\CAuthServiceProvider"
```


## Using package

#### Step 1

Change defaults in `config/apiauth.php` setting

- a service name of your remote application name that will connect to your laravel app i.e **REMOTE_APP**
- service token key so it will point to your token in `.env` file i.e **REMOTE_APP_TOKEN**

#### Step 2

- Add your remote app token in `.env` file
```
// .env

REMOTE_APP_TOKEN=<secret-token>
```

#### Step 3

- Add 'apiauth:**REMOTE_APP**' middleware to your routes
```php
// /routes/api.php

Route::group(['prefix' => 'v1', 'middleware' => ['apiauth:REMOTE_APP']], function () {
    // your routes
});
```

#### That's all

Your urls within your middleware is accessible only if the valid token is provided

- In `GET` or `POST` request
- In request header as `Authorization Bearer`
- In json raw body

You're free to change token name (`api_token` by default) in configuration file as well as
authorization methods to be checked. 
Also you can set as many services as you want.
