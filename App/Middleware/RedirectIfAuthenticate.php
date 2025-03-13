<?php

namespace App\Middleware;

/**
 * Class RedirectIfAuthenticate
 * 
 * Middleware to redirect authenticated users away from guest-only pages.
 */
class RedirectIfAuthenticate
{
    /**
     * Handle authentication check and redirect if the user is logged in.
     *
     * @return void
     */
    public static function handle() {
        if (isset($_SESSION['user_id'])) {
            // If not, redirect them to the login page
            header('Location: /');
            exit();
        }
    }
}
