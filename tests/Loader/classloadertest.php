<?php

namespace snakeMvc\Tests\Loader;
use snakeMvc\Framework\Loader\ClassLoader;

require_once __DIR__.'\..\..\lib\Loader\ClassLoader.php';

class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{
	protected $loader;

	public function setUp()
	{
		$this->loader = new ClassLoader();
	}

	public function testSimpleClass()
	{
		$this->assertEquals('Foo.php', $this->loader->getFilePath('Foo'));
	}

	public function testPrefixedClass()
	{
		$this->assertEquals('Bar\Foo.php', $this->loader->getFilePath('Bar_Foo'));

		$this->loader->setPrefixes('Bar_', 'Barrage');

		$this->assertEquals('Barrage\Foo.php', $this->loader->getFilePath('Bar_Foo'));
	}

	public function testNamespacedClass()
	{
		$this->assertEquals('Bar\Foo.php', $this->loader->getFilePath('Bar\Foo'));

		$this->loader->setNamespaces('Bar', 'Barrage');

		$this->assertEquals('Barrage\Foo.php', $this->loader->getFilePath('Bar\Foo'));
	}
}
