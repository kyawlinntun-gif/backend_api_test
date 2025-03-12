<?php

namespace App\Validator;

/**
 * Class Validator
 * 
 * A simple validation class for handling form validation rules.
 */
class Validator
{
    /** @var array Holds validation errors */
    private $errors = [];
    /** @var array Holds input data */
    private $data = [];

    /**
     * Validator constructor.
     *
     * @param array $data The input data to validate.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validates the input data based on the given rules.
     *
     * @param array $rules An associative array of fields and their validation rules.
     * @return bool True if validation passes, false otherwise.
     */
    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $ruleset) {
            $fieldValue = isset($this->data[$field]) ? $this->data[$field] : null;
            $rulesArray = explode('|', $ruleset);
            foreach ($rulesArray as $rule) {
                if (strpos($rule, ':') !== false) {
                    list($ruleName, $param) = explode(':', $rule);
                    $this->applyRule($field, $ruleName, $param, $fieldValue);
                } else {
                    $this->applyRule($field, $rule, null, $fieldValue);
                }
                if (isset($this->errors[$field])) {
                    break;
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * Applies a validation rule to a field.
     *
     * @param string $field The field name.
     * @param string $rule The rule name.
     * @param string|null $param The optional rule parameter.
     * @param mixed $value The field value.
     * @return void
     */
    public function applyRule(string $field, string $rule, ?string $param, mixed $value): void
    {
        switch ($rule) {
            default:
                break;
        }
    }

    /**
     * Adds an error message for a specific field.
     *
     * @param string $field The field name.
     * @param string $message The error message.
     * @return void
     */
    private function addError(string $field, string $message): void
    {
        // Add only if no previous error for the field
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        // Add error message for the field
        $this->errors[$field][] = $message;
    }

    /**
     * Gets all validation errors.
     *
     * @return array An associative array of field errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
