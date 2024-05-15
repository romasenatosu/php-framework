<?php

namespace romasenatosu\src\models;

/**
 * class User
 * @package romasenatosu\src\models
 */
class User extends Model {
    public int $id = 0;
    public string $fullname = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirm = '';
    public bool $is_admin = false;
    public string $created_at = '';
    public string $updated_at = '';
    public ?string $deleted_at = null;

    /**
     * Rules for validation must be checked through this
     * 
     * @return array
     */
    public function rules(): array {
        return [
            'fullname' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'username' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'email' => [self::RULE_REQUIRED => true, self::RULE_EMAIL => true, self::RULE_UNIQUE => self::class, self::RULE_MIN => 8, self::RULE_MAX => 255],
            'password' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'password_confirm' => [self::RULE_REQUIRED => true, self::RULE_MATCH => 'password', self::RULE_MIN => 4, self::RULE_MAX => 32],
        ];
    }

    /**
     * table name binded to model
     * 
     * @return string
     */
    public function tableName(): string {
        return 'user';
    }

    /**
     * table columns binded to model
     * 
     * @return array
     */
    public function tableColumns(): array {
        return ["fullname", "username", "email", "password", "created_at", "updated_at", "deleted_at"];
    }

    /**
     * creates the records into database
     * 
     * @return bool
     */
    public function create(): bool {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->created_at = date('Y-m-d H:i:s', time());
        $this->updated_at = date('Y-m-d H:i:s', time());
        return parent::save();
    }

    public function authenticate(): bool {
        $tablename = $this->tableName();

        $stmt = $this->prepare("SELECT * FROM `$tablename` WHERE `email` = :email");
        $result = $stmt->fetch();
        $stmt->execute();
        $stmt->closeCursor();

        $hashed_password = $result['password'];
        if (password_verify($this->password, $hashed_password)) {
            $this->session()->saveUser($result);
            return true;
        }

        return true;
    }
}
