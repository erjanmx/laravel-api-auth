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

Change defaults in `config/apiauth.php`

```php
<?php

return [
    'services' => [

        'MY_APP' => [                          // this is the name of the middleware of route group to be protected
            'tokenName' => 'api_token',        // name of key that will be checked for secret value
            'token' => env('MY_APP_TOKEN'),    // secret value that is retrieved from env vars and needs to be passed in requests in order to get access to your protected urls

            'allowJsonToken' => true,        
            'allowBearerToken' => true,        
            'allowRequestToken' => true,       
        ]
    ],
];

```

#### Step 2

- Add your secret value in `.env` file
```
// .env

...your other variables

MY_APP_TOKEN=my-secret
```

#### Step 3

- Add group with middleware in your routes file
```php

Route::group(['prefix' => 'api', 'middleware' => ['apiauth:MY_APP']], function () { // note the `MY_APP` that should match the name in your config we changed above
    Route::any('/', function () {
        return 'Welcome!';
    });
});
```

#### That's all

Your urls within your group is accessible only if valid token is provided

- In `GET` or `POST` request

![image](https://user-images.githubusercontent.com/4899432/114033708-c649ee80-987d-11eb-9d81-5bb1505cb4a7.png)
![image](https://user-images.githubusercontent.com/4899432/114033620-b3371e80-987d-11eb-8548-39279a184645.png)

- In request header as `Authorization Bearer`

![image](https://user-images.githubusercontent.com/4899432/114033931-027d4f00-987e-11eb-9809-2e34d9aae793.png)

- In `json` raw body

![image](https://user-images.githubusercontent.com/4899432/114034101-2ccf0c80-987e-11eb-825b-409f62204e57.png)


You're free to change token name (`api_token` by default) in configuration file as well as
authorization methods to be checked. 
Also you can set as many services as you want.
