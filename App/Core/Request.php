<?php

namespace App\Core;

/**
 * Class Request
 * 
 * Handles HTTP request data including method, URI, POST data, and file uploads.
 */
class Request
{
    /**
     * Get the HTTP request method (GET, POST, etc.).
     *
     * @return string The request method.
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Get the requested URI.
     *
     * @return string The request URI.
     */
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    /**
     * Retrieve a value from the POST request data.
     *
     * @param string $key The key to retrieve from the POST data.
     * @return mixed|null The value if found, otherwise null.
     */
    public function get(string $key): mixed
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }

    /**
     * Retrieve an uploaded file.
     *
     * @param string $key The file input name.
     * @return array|null The file data if uploaded successfully, otherwise null.
     */
    public function file(string $key): ?array
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] === 0 ? $_FILES[$key] : null;
    }
}
