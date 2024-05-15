<?php

namespace romasenatosu\core;

/**
 * class Response
 * @package romasenatosu\core
 */
class Response {
    /**
     * 
     */
    function __construct() {

    }

    /**
     * Sets the current HTTP status code
     * 
     * @param int code
     * @return void
     */
    public function status(int $code):void {
        http_response_code($code);
    }
}
