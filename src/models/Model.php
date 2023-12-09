<?php

namespace inserveofgod\models;

/**
 * class Model
 * @package inserveofgod\models
 */
abstract class Model {
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MAX = "max";
    public const RULE_MIN = "min";
    public const RULE_MATCH = "match";

    private array $errors = [];

    public function setErrors(array $errors): void {
        $this->errors = $errors;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function hasErrors(): bool {
        return empty($this->errors);
    }

    public function hasError(string $attribute): mixed {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute): string {
        return $this->errors[$attribute][0] ?? "";
    }

    /**
     * Returns the error messages relative to its rule
     * 
     * @return array
     */
    protected function getErrorMessages(): array {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be a valid e-mail address",
            self::RULE_MAX => "This field must be less than %d",
            self::RULE_MIN => "This field must be greater than %d",
            self::RULE_MATCH => "This field must match with %s",
        ];
    }

    /**
     * Returns the error message related to its rule
     * 
     * @param string rule
     * @return string
     */
    protected function getErrorMessage(string $rule): string {
        return $this->getErrorMessages()[$rule] ?? "";
    }

    /**
     * Adds error messages to errors by the rule and attribute
     * 
     * @param string attribue
     * @param string rule
     * @param mixed params
     * @return void
     */
    protected function addError(string $attribute, string $rule, mixed ...$params): void {
        $this->errors[$attribute][] = sprintf($this->getErrorMessage($rule), ...$params);
    }

    /**
     * Loads the submitted form data
     * 
     * @param array data
     * @return void
     */
    public function loadData(array $data):void {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Rules for validation must be checked through this
     */
    abstract public function rules(): array;

    /**
     * checks the validation of the submitted form data
     * 
     * @return bool
     */
    public function validate():bool {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule_name => $rule) {
                if ($rule_name === self::RULE_REQUIRED and self::RULE_REQUIRED and !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($rule_name === self::RULE_EMAIL and self::RULE_EMAIL and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($rule_name === self::RULE_MIN and strlen($value) < $rule) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($rule_name === self::RULE_MAX and strlen($value) > $rule) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                if ($rule_name === self::RULE_MATCH and $value !== $this->{$rule}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        return $this->hasErrors();
    }
}
