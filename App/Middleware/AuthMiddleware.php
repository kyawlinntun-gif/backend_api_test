<?php

namespace App\Middleware;

/**
 * Class AuthMiddleware
 * 
 * Middleware to handle authentication checks for protected routes.
 */
class AuthMiddleware
{
    /**
     * Handle authentication check.
     *
     * @return void
     */
    public static function handle(array $allowedRoles) {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], $allowedRoles)) {
            header("location: /admin/login");
            exit();
        }
    }
}
