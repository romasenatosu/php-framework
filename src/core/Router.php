<?php

namespace inserveofgod\core;

/**
 * class Router
 * @package inserveofgod\core
 */
class Router {
    protected array $routes = array();

    private Request $request;
    private Response $response;

    /**
     * @param Request request
     * @param Response response
     */
    function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Stores route for get request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function get(string $path, mixed $callback):void {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Stores route for post request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function post(string $path, mixed $callback):void {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Stores route for put request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function put(string $path, mixed $callback):void {
        $this->routes['put'][$path] = $callback;
    }

    /**
     * Stores route for delete request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function delete(string $path, mixed $callback):void {
        $this->routes['delete'][$path] = $callback;
    }

    /**
     * Stores route for options request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function options(string $path, mixed $callback):void {
        $this->routes['options'][$path] = $callback;
    }

    /**
     * Stores route for patch request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function patch(string $path, mixed $callback):void {
        $this->routes['patch'][$path] = $callback;
    }

    /**
     * Stores route for any request
     * 
     * @param string path
     * @param mixed callback
     * @return void
     */
    public function any(string $path, mixed $callback):void {
        $this->routes['any'][$path] = $callback;
    }

    /**
     * Resolves the request uri and method with callback
     * 
     * @return mixed
     */
    public function resolve():mixed {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? null;

        if (is_null($callback)) {
            $this->response->status(404);
            return $this->render("errors/404");
        }
        
        if (is_string($callback)) {
            return $this->render($callback);
        }
        
        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * Renders the html view for desired route
     * 
     * @param string route
     * @param array params
     * @return string
     */
    public function render(string $route, array $params = []):string {
        $view_content = $this->renderView($route, $params);
        return $this->renderContent($view_content, $params);
    }

    /**
     * Renders the desired view for html view
     * 
     * @param string view
     * @param array params
     * @return string
     */
    public function renderView (string $view, array $params):string {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/src/views/$view.php";
        return ob_get_clean();
    }

    /**
     * Renders the base view for html view
     * 
     * @param array params
     * @return string
     */
    public function renderBase(array $params):string {
        return $this->renderView("base", $params);
    }

    /**
     * Renders the desired content for html view
     * 
     * @param string content
     * @return string
     */
    public function renderContent(string $content, array $params):string {
        $base_layout = $this->renderBase($params);
        return str_replace("{{ content }}", $content, $base_layout);
    }
}
