<?php

namespace snakeMvc\Tests\Routes;

class RoutesIniTest extends \PHPUnit_Framework_TestCase
{
	protected $routes;

	public function setUp()
	{
		$this->routes = parse_ini_file('../../app/WouterJ/config/routes.ini', true);
	}

	public function testSimpleRoutes()
	{
		$this->assertEqual('Welcome::index', $this->routes['/']['to']);
	}
}
