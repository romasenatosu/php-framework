<?php

namespace inserveofgod\core;

/**
 * class Application
 * @package inserveofgod\core
 */
class Application {
    public static Application $app;
    public static string $ROOT_DIR;
    public Request $request;
    public Response $response;
    public Router $router;

    /**
     * @param string root_dir
     */
    function __construct(string $root_dir) {
        self::$ROOT_DIR = $root_dir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * Runs the application
     * 
     * @return void
     */
    public function run():void {
        echo $this->router->resolve();
    }
}
