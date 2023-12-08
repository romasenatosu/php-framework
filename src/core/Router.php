<?php

namespace inserveofgod\core;

/**
 * class Router
 * 
 */
class Router {
    protected $routes = array();

    /**
     * 
     */
    function __construct() {

    }

    /**
     * Stores route for get request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function get(string $path, mixed $callback) {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Stores route for post request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function post(string $path, mixed $callback) {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Stores route for put request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function put(string $path, mixed $callback) {
        $this->routes['put'][$path] = $callback;
    }

    /**
     * Stores route for delete request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function delete(string $path, mixed $callback) {
        $this->routes['delete'][$path] = $callback;
    }

    /**
     * Stores route for options request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function options(string $path, mixed $callback) {
        $this->routes['options'][$path] = $callback;
    }

    /**
     * Stores route for patch request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function patch(string $path, mixed $callback) {
        $this->routes['patch'][$path] = $callback;
    }

    /**
     * Stores route for any request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function any(string $path, mixed $callback) {
        $this->routes['any'][$path] = $callback;
    }


}

