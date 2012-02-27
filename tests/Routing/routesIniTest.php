<?php

namespace snakeMvc\Tests\Routes;

class RoutesIniTest extends \PHPUnit_Framework_TestCase
{
	protected $routes;

	public function setUp()
	{
		$this->routes = parse_ini_file('../app/WouterJ/config/routes.ini', true);
	}

	public function testSimpleRoutes()
	{
		$this->assertEquals('Welcome::index', $this->routes['/']['to']);
	}

	public function testParamRoutes()
	{
		$this->assertEquals('Welcome::sayHello', $this->routes['/hello/{name}']['to']);
	}

	public function testConditionParamRoutes()
	{
		$this->assertEquals('0-9', $this->routes['/page/{slug}']['where.slug']);
	}
}
