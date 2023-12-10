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
    public Database $database;
    public Router $router;

    /**
     * @param string root_dir
     * @param array enviro_config
     */
    function __construct(string $root_dir, array $enviro_config = []) {
        self::$ROOT_DIR = $root_dir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $this->database = new Database($enviro_config['db']);
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
