<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://localhost/laravel_mongodb/public/order_now',
        'order_now',
        '/order_now',
        'http://localhost/laravel_mongodb/public/add_new_order',
        'add_new_order',
        '/add_new_order',
    ];
}
