<?php

namespace snakeMvc\Framework\Controller;
use snakeMvc\Framework\Config\Routes;

/**
 * This object handles the incomming requests
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Controller
 * @singleton
 */
class FrontController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * The hard work of the method
     *
     * @param string $path The path to the file
     * @return object $route The route object
     */
    public function dispatch( $path )
    {
        $routes = Routes::getRoutes();

        foreach ($routes as $r) {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($r->matches($path, $method) === true) {
                $controller = 'snakeMvc\Bundle\\'.APP_NAME.'\Controllers\\'.$r->getController().'Controller';
                $controller = new $controller($this->container);
                $response = call_user_func_array(array($controller, $r->getAction()), $r->getParams());

                if (get_class($response) == 'snakeMvc\Framework\BrowserKit\Response') {
                    $response->show();
                }
            }
        }
    }
}
