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
    public static function handle() {
        // Check if the user is not logged in
        if (!isset($_SESSION['user_id'])) {
            // If not, can't go to logout page 
            header('Location: /admin/login');
            exit();
        }
    }
}
