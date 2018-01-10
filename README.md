<!--
  Title: Laravel API-Auth
  Description: Dead simple Laravel api authorization middleware
  Author: erjanmx
  -->
  
[![Build Status](https://travis-ci.org/erjanmx/laravel-api-auth.svg?branch=master)](https://travis-ci.org/erjanmx/laravel-api-auth)
[![Latest Stable Version](https://poser.pugx.org/erjanmx/laravel-api-auth/v/stable)](https://packagist.org/packages/erjanmx/laravel-api-auth) 
[![Total Downloads](https://poser.pugx.org/erjanmx/laravel-api-auth/downloads)](https://packagist.org/packages/erjanmx/laravel-api-auth)

# Laravel Api Auth

Laravel gives easy ways to handle api authorization using user based tokens, but sometimes you need to use a single token to give access to your application, especially when you're developing two apps that need to be connected, or perhaps you're in need of connecting Telegram-bot to your app endpoint using webhooks

Laravel-api-auth makes that easy as breathe, no migrations, no models

### Installing package

If you're using Laravel prior to 5.5, consider using [v0.1](https://github.com/erjanmx/laravel-api-auth/tree/v0.1) branch

```bash
$ composer require erjanmx/laravel-api-auth
```

Publish the Package configuration

```bash
$ php artisan vendor:publish --provider="Apiauth\Laravel\CAuthServiceProvider"
```


## Using package

#### Step 1

Change defaults in `config/apiauth.php` setting

- a service name of your remote application name that will connect to your laravel app for example **REMOTE_APP**
- service token key so it will point to your token in `.env` file for example **REMOTE_APP_TOKEN**

#### Step 2

- Add your remote app token in `.env` file
```
// .env

...your other variables

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

Your urls within your group is accessible only if valid token is provided

- In `GET` or `POST` request
- In request header as `Authorization Bearer`
- In `json` raw body

You're free to change token name (`api_token` by default) in configuration file as well as
authorization methods to be checked. 
Also you can set as many services as you want.
