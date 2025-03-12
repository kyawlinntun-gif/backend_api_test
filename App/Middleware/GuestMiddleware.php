<?php

namespace App\Middleware;

/**
 * Class GuestMiddleware
 * 
 * Middleware to restrict authenticated users from accessing certain routes.
 */
class GuestMiddleware
{
    /**
     * Handle guest-only access check.
     *
     * @return void
     */
    public static function handle() {}
}
