<?php

namespace romasenatosu\src\models;

use romasenatosu\core\Application;
use romasenatosu\core\Session;
use PDO;
use PDOException;
use PDOStatement;

/**
 * class Model
 * @package romasenatosu\src\models
 */
abstract class Model
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MAX = "max";
    public const RULE_MIN = "min";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";

    private array $errors = [];

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return empty($this->errors);
    }

    public function hasError(string $attribute): mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute): string
    {
        return $this->errors[$attribute][0] ?? "";
    }

    /**
     * Returns the error messages relative to its rule
     * 
     * @return array
     */
    protected function getErrorMessages(): array
    {
        return [
            self::RULE_REQUIRED => "This field is required",
            self::RULE_EMAIL => "This field must be a valid e-mail address",
            self::RULE_MAX => "This field must be less than %d",
            self::RULE_MIN => "This field must be greater than %d",
            self::RULE_MATCH => "This field must match with %s",
            self::RULE_UNIQUE => "This field must be unique with %s",
        ];
    }

    /**
     * Returns the error message related to its rule
     * 
     * @param string rule
     * @return string
     */
    protected function getErrorMessage(string $rule): string
    {
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
    protected function addError(string $attribute, string $rule, mixed ...$params): void
    {
        $this->errors[$attribute][] = sprintf($this->getErrorMessage($rule), ...$params);
    }

    /**
     * Rules for validation must be checked through this
     * 
     * @return array
     */
    abstract public function rules(): array;

    /**
     * table name binded to model
     * 
     * @return string
     */
    abstract public function tableName(): string;

    /**
     * table columns binded to model
     * 
     * @return array
     */
    abstract public function tableColumns(): array;

    /**
     * Loads the submitted form data
     * 
     * @param array data
     * @return void
     */
    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * checks the validation of the submitted form data
     * 
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule_name => $rule_value) {
                if ($rule_name === self::RULE_REQUIRED and self::RULE_REQUIRED and !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($rule_name === self::RULE_EMAIL and self::RULE_EMAIL and !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($rule_name === self::RULE_MIN and strlen($value) < $rule_value) {
                    $this->addError($attribute, self::RULE_MIN, $rule_value);
                }

                if ($rule_name === self::RULE_MAX and strlen($value) > $rule_value) {
                    $this->addError($attribute, self::RULE_MAX, $rule_value);
                }

                if ($rule_name === self::RULE_MATCH and $value !== $this->{$rule_value}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule_value);
                }

                if ($rule_name === self::RULE_UNIQUE) {
                    $classname = $rule_value;
                    $tablename = $classname::tableName();

                    try {
                        $this->pdo()->beginTransaction();

                        $stmt = $this->prepare("SELECT `id` FROM `$tablename` WHERE `$attribute` = :value");
                        $stmt->bindParam(':value', $value, PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetchObject();
                        $stmt->closeCursor();

                        if ($result) {
                            $this->addError($attribute, self::RULE_UNIQUE, $attribute);
                        }

                        $this->pdo()->commit();
                    } catch (PDOException $e) {
                        var_dump($e);
                        $this->pdo()->rollBack();
                        return false;
                    }
                }
            }
        }

        return $this->hasErrors();
    }

    /**
     * Saves the records into database
     * 
     * @return bool
     */
    protected function save(): bool
    {
        $tablename = $this->tableName();
        $columns = $this->tableColumns();

        $columns_params = implode(",", $columns);
        $value_params = implode(",", array_map(fn($column) => ":$column", $columns));

        try {
            $this->pdo()->beginTransaction();

            $stmt = $this->prepare("INSERT INTO `$tablename` ($columns_params) VALUES ($value_params)");

            foreach ($columns as $column) {
                $stmt->bindValue(":$column", $this->{$column});
            }

            $stmt->execute();
            $stmt->closeCursor();
            $this->pdo()->commit();

        } catch (PDOException $e) {
            var_dump($e);
            $this->pdo()->rollBack();
            return false;
        }

        return true;
    }

    /**
     * An alias function for prepare statement in Application
     * 
     * @param string query
     * @param array|null options
     * @return PDOStatement|bool
     */
    protected function prepare(string $query, array|null $options = []): PDOStatement|bool
    {
        return $this->pdo()->prepare($query, $options);
    }

    /**
     * An alias function for pdo property in Application
     * 
     * @return PDO
     */
    protected function pdo(): PDO
    {
        return Application::$app->database->pdo;
    }

    /**
     * An alias function for session property in Session
     * 
     * @return Session
     */
    protected function session(): Session
    {
        return Application::$app->session;
    }
}
