<?php

namespace snakeMvc\Tests\DependencyInjection;

require '../../lib/snakeMvc/DependencyInjection/serviceContainer.php';
use snakeMvc\Framework\DependencyInjenction\ServiceContainer;

class ServiceContainerTest extends \PHPUnit_Framework_TestCase
{
	protected $container;

	public function setUp() {
		$this->container = new ServiceContainer();
	}

	protected function setUpService()
	{
		$this->container->set('header', function() {
			$arr = (object) array(
				'foo' => 'hello',
				'bar' => 'lorem',
			);
			$std = new \stdClass($arr);
			$std->something = 'foobar';

			return $std;
		});
	}

	public function testServiceMagic() {
		$this->setUpService();

		$this->assertEquals('stdClass', get_class($this->container->getHeader()));
	}

	public function testServiceArray() {
		$this->setUpService();

		$this->assertEquals('stdClass', get_class($this->container['header']));
	}

	public function testVariables() {
		$this->container->set('foo', 'bar');

		$this->assertEquals('bar', $this->container->get('foo'));
	}
}
