<?php
namespace App\Validator;
require_once(__DIR__ . '/../../config/constants.php');

class Rules 
{
    /**
     * Checks if the given value is empty.
     *
     * @param mixed $value The value to check.
     * @return string|null Returns an errors message if validation fails, otherwise null.
     */
    public function required(mixed $value): ?string
    {
        if (empty($value)) {
            return REQUIRED;
        }
        return null;
    }

    /**
     * Validates if the given value is a valid email address.
     *
     * @param string $value The email to validate.
     * @return string|null Returns an error message if validation fails, otherwise null.
     */
    public function email(string $value): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return INVALID_EMAIL;
        }
        return null;
    }

    /**
     * Validates if the given value meets the minimum length.
     *
     * @param string $value The value to check.
     * @param integer $minLength The minimum length required.
     * @return string|null Returns an error message if validation fails, otherwise null.
     */
    public function min(string $value, int $minLength): ?string
    {
        if (strlen($value) < $minLength) {
            return "This field must be at least $minLength characters long.";
        }
        return null;
    }

    /**
     * Validates if the given value is a string.
     *
     * @param mixed $value Teh value to check.
     * @return string|null Returns an error message if validation fails, otherwise null.
     */
    public function string(mixed $value): ?string
    {
        if (!is_string($value)) {
            return INVALID_STRING;
        }
        return null;
    }
}
