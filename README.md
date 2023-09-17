# Convert Persian Numnbers to English Numbers
# تبدیل اعداد فارسی به انگلیسی در لاراول
This middleware converts Persian and Arabic numbers in specified JSON fields to English numbers in Laravel applications. It ensures consistency in the number representation.

## Installation

To use this middleware in your Laravel application, follow these steps:

1. Copy the `CorrectNumberMiddleware.php` file into your Laravel project's `app/Http/Middleware` directory.

2. Add the middleware to your Laravel application's middleware stack. You can do this by adding it to the `$middleware` property in the `app/Http/Kernel.php` file like this:

   ```php
   protected $middleware = [
       // ...
       \App\Http\Middleware\CorrectNumberMiddleware::class,
   ];


## Usage
You can use this middleware in your Laravel application to ensure consistent number representation in your JSON responses

```php

Route::post('/transfer-money', [\App\Http\Controllers\Account\TransferController::class, '__invoke'])
    ->middleware(\App\Http\Middleware\CorrectNumberMiddleware::class .':source_card_number,dest_card_number,amount');

```
