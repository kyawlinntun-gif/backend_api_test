<?php
if (!function_exists('view')) {
    function view(string $viewPath, array $data = [])
    {
        // Convert dot notation to directory separators
        $viewFile = "../app/Views/" . str_replace('.', '/', $viewPath) . ".php";
        // Check if the view file exists
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: $viewFile");
        }
        // Extract data for use in the view
        extract($data);
        // Include the view file
        require $viewFile;
    }
}
if (!function_exists('assets')) {
    function assets($path)
    {
        // Ensure path is relative to the public folder
        return '/' . ltrim($path, '/');
    }
}
if (!function_exists('getValidationError')) {
    function getValidationError($field, $context)
    {
        if (isset($_SESSION['errors'][$context][$field])) {
            $message = $_SESSION['errors'][$context][$field][0];
            return htmlspecialchars($message);
        }
        return [];
    }
}
