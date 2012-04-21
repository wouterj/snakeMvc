<?php

namespace snakeMvc\Tests;

use snakeMvc\Framework\Registery;

require_once '../lib/snakeMvc/Registery.php';

class RegisteryTest extends \PHPUnit_Framework_TestCase
{
	protected $registery;

	public function setUp()
	{
		$this->registery = new Registery;
	}

	protected function remove()
	{
		foreach( func_get_args() as $key )
			unset($this->registery[$key]);
	}

	public function testNormalValueWithStaticFunctions()
	{
		Registery::set('name', 'foo');

		$this->assertEquals('foo', Registery::get('name'));

		Registery::set('foo', Array('bar', 'baz'));

		$this->assertEquals(Array('bar', 'baz'), Registery::get('foo'));

		$this->remove('name', 'foo');
	}

	public function testNormalValueWithMagicFunctions()
	{
		$this->registery->name = 'foo';

		$this->assertEquals('foo', $this->registery->name);

		$this->registery->foo = Array('bar', 'baz');

		$this->assertEquals(Array('bar', 'baz'), $this->registery->foo);

		$this->remove('name', 'foo');
	}

	public function testCallableWithMagicFunctions()
	{
		$this->registery->foo = function() {
			return 'bar';
		};

		$this->assertEquals('bar', $this->registery->foo());

		$this->remove('foo');
	}

	public function testNormalValueWithArrayAccessFunctions()
	{
		$this->registery['name'] = 'foo';

		$this->assertEquals('foo', $this->registery['name']);

		$this->registery['foo'] = Array('bar', 'baz');

		$this->assertEquals(Array('bar', 'baz'), $this->registery['foo']);

		$this->remove('name', 'foo');
	}
}
