<?php

namespace romasenatosu\core;

use romasenatosu\src\models\User;

/**
 * class Session
 * @package romasenatosu\core
 */
class Session {
    private const KEY_FLASH = "flashes";
    private const KEY_USER = "user";

    /**
     * 
     */
    function __construct() {
        session_start();
    }

    /**
     * Creates flash message to store in the session in order to inform user
     * 
     * @param string type
     * @param string message
     * @return void
     */
    public function addFlash(string $type, string $message):void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::KEY_FLASH][] = ['type' => $type, 'message' => $message];
        }
    }

    /**
     * Returns flash messagees in order to inform user
     * 
     * @return array
     */
    public function getFlashes():array {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $flashes = $_SESSION[self::KEY_FLASH] ?? [];

            if (count($flashes) > 0) {
                $_SESSION[self::KEY_FLASH] = [];
            }

            return $flashes;
        }

        return [];
    }

    /**
     * stores user session
     * 
     * @param array user_data
     * @return void
     */
    public function saveUser(array $user_data):void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::KEY_USER] = $user_data;
        }
    }

    /**
     * Gets user session
     * 
     * @return ?array
     */
    public function getUser():?array {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::KEY_USER] ?? null;
        }

        return null;
    }

    /**
     * clears user session
     * 
     * @return void
     */
    public function removeUser():void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION[self::KEY_USER] = null;
        }
    }
}
