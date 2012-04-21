<?php

namespace snakeMvc\Framework\Config;
use snakeMvc\Framework\Config\Parser\IniParser;
use snakeMvc\Framework\Routing\Route;

/**
* Get the routes
*
* @author Wouter J
* @package snakeMvc
* @subpackage Config
*/
class Routes
{
    /**
    * All routes from the routes.ini file
    *
    * @var array
    */
    protected static $routes;

    /**
    * Get all routes
    *
    * @return array $routes All routes with their path, controller::action and params
    */
    public static function getRoutes()
    {
        if (self::$routes === null) {
            self::$routes = self::generateRoutes();
        }

        return self::$routes;
    }

    /**
    * Generate the routes
    *
    * @access protected
    * @return array $routes The routes
    */
    protected static function generateRoutes()
    {
        $routeParser = new IniParser(file_get_contents(sprintf('%sconfig%sroutes.ini', APP_ROOT, DIRECTORY_SEPARATOR)));
        $data = $routeParser->parse(true);
        $routes = array();

        foreach ($data as $name => $info) {
            $path = $info['path'];
            if (preg_match_all('/\(*\/{(\w*?)}\)*/', $path, $params)) {
                foreach ($params[0] as $key => $param) {
                    $optional = ( $param[0] === '('
                                    ? true
                                    : false );
                    $info['params'][$params[1][$key]] = $optional;
                }
            }
            if (!isset($info['method'])) {
                $info['method'] = 'GET';
            }
            $info['name'] = $name;

            $routes[$name] = new Route($path, $info);
        }

        return $routes;
    }
}
