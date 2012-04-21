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
    /**
     * The instance
     *
     * @var object
     */
    protected static $instance;

    final public function __wakeup() {
        throw new BadMethodCallException(sprintf('%s is a singleton, it is not allowed to serialize it.', __CLASS__));
    }
    final public function __clone() {
        throw new BadMethodCallException(srpintf('%s is a singleton, it is not allowed to clone it.', __CLASS__));
    }
    final private function __construct()
    {}

    /**
     * Get the single instance
     *
     * @return object $instance The instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
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
                $controller = new $controller();
                $response = call_user_func_array(array($controller, $r->getAction()), $r->getParams());

                if (get_class($response) == 'snakeMvc\Framework\BrowserKit\Response') {
                    $response->show();
                }
            }
        }
    }
}
