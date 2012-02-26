<?php

namespace snakeMvc\Framework\Config;

/**
 * Get the routes
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Config
 */
class Route
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
	 * @return array $routes The routes
	 */
	protected static function generateRoutes()
	{
		$routeParser = new IniParser('');
	}
}
