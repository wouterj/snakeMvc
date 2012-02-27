<?php

namespace snakeMvc\Framework\Config;
use snakeMvc\Framework\Config\Parser\IniParser;

define('BUNDLE_ROOT', sprintf(__DIR__.'%1$s..%1$s..%1$sapp%1$sWouterJ%1$s', DIRECTORY_SEPARATOR));
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
		if( self::$routes === null )
			self::$routes = self::generateRoutes();
		return self::$routes;
	}

	/**
	 * Generate the routes
	 *
	 * @access protected
	 * @return array $data The routes
	 */
	protected static function generateRoutes()
	{
		$routeParser = new IniParser(file_get_contents(sprintf('%sconfig%sroutes.ini', BUNDLE_ROOT, DIRECTORY_SEPARATOR)));
		$data = $routeParser->parse(true);

		foreach( $data as $path => $info )
		{
			if( preg_match('/{(.*?)}/', $path, $params) )
			{
				array_shift($params);
				$data[$path]['params'] = Array();

				foreach( $params as $param )
				{
					$data[$path]['params'][] = $param;
				}
			}
		}
		return $data;
	}
}
