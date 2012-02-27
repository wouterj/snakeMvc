<?php

namespace snakeMvc\Tests\Config;
use snakeMvc\Framework\Config\Routes;

require_once __DIR__.'\..\..\lib\Config\Parser\IniParser.php';
require_once __DIR__.'\..\..\lib\Config\Parser\AbstractParser.php';
require_once __DIR__.'\..\..\lib\Config\routes.php';

class TestRoutes extends \PHPUnit_Framework_TestCase
{
	public function testRoutes()
	{
		$routes = Routes::getRoutes();

		$this->assertEquals('', $routes);
	}
}
