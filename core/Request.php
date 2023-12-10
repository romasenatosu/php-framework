<?php

namespace inserveofgod\core;

/**
 * class Request
 * @package inserveofgod\core
 */
class Request {
    /**
     * 
     */
    function __construct() {

    }

    /**
     * Returns the request method
     * 
     * @return string
     */
    public function getMethod(): string {
        return strtolower($_SERVER["REQUEST_METHOD"] ?? 'get');
    }

    /**
     * Checks whether request method is get or else
     * 
     * @return bool
     */
    public function isGet(): bool {
        return $this->getMethod() === 'get';
    }

    /**
     * Checks whether request method is post or else
     * 
     * @return bool
     */
    public function isPost(): bool {
        return $this->getMethod() === 'post';
    }


    /**
     * Returns the request uri base on SEO url
     * 
     * @return string
     */
    public function getPath():string {
        $request_uri = $_SERVER['REQUEST_URI'] ?? '/';
        $question_mark_pos = strpos($request_uri,'?');

        if ($question_mark_pos > 0) {
            return substr($request_uri, 0, $question_mark_pos);
        }

        return $request_uri;
    }

    /**
     * Returns the submitted data form body
     * 
     * @return array
     */
    public function getBody():array {
        $body = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
