<?php

namespace inserveofgod\models;

/**
 * class User
 * @package inserveofgod\models
 */
class User extends Model {
    public int $id = 0;
    public string $fullname = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirm = '';

    /**
     * Rules for validation must be checked through this
     */
    public function rules(): array {
        return [
            'fullname' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'username' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'email' => [self::RULE_REQUIRED => true, self::RULE_EMAIL => true, self::RULE_MIN => 8, self::RULE_MAX => 255],
            'password' => [self::RULE_REQUIRED => true, self::RULE_MIN => 4, self::RULE_MAX => 32],
            'password_confirm' => [self::RULE_REQUIRED => true, self::RULE_MATCH => 'password', self::RULE_MIN => 4, self::RULE_MAX => 32],
        ];
    }
}
