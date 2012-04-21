<?php

use snakeMvc\Framework\Debugging\Debug;
require_once 'Debug.php';

// strings and int/floates
Debug::dump('An example string');

Debug::dump(12);
Debug::dump(12.12);

// arrays
Debug::dump(Array(
	'hello',
	'world',
	12,
));
Debug::dump(Array(
	'foo' => 'hello',
	'bar' => 'world',
	12,
));

// objects
class Test
{
	protected $hello = 'default';
	private $foo = array();
	public $bar;

	public function getFoo()
	{
		return $this->foo;
	}
}

Debug::dump(new Test);
