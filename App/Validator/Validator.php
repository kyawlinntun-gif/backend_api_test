<?php

namespace App\Validator;

use App\Validator\Rules;

class Validator
{
    private $errors = [];
    private $data = [];
    private $rules;

    /**
     * Constructor to initialize validation data.
     *
     * @param array $data The imput data to be validated.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->rules = new Rules();
    }

    /**
     * Validates the input data against the given rules.
     *
     * @param array $rules An associative array where keys are field names, and values are validation rules separated by "|".
     * @return boolean Returns true if validation passes, otherwise false.
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
     * Applies a specific validation rule to a given field.
     *
     * @param string $field The field name being validated.
     * @param string $rule The validation rule name.
     * @param string|null $param Optional parameter for the rule
     * @param mixed $value The value being validated.
     * @return void
     */
    public function applyRule(string $field, string $rule, ?string $param, mixed $value): void
    {
        $error = null;
        switch ($rule) {
            case 'required':
                $error = $this->rules->required($value);
                break;
            case 'email':
                $error = $this->rules->email($value);
                break;
            case 'string':
                $error = $this->rules->string($value);
                break;
            case 'min':
                $error = $this->rules->min($value, $param);
                break;
            default:
                break;
        }
        if ($error) {
            $this->addError($field, $error);
        }
    }

    /**
     * Stores validation error messages for a specific field.
     *
     * @param string $field The field name with validation errors.
     * @param string $message The validation error message.
     * @return void
     */
    public function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    /**
     * Retrieves all validation errors.
     *
     * @return array An associative array of validation errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
