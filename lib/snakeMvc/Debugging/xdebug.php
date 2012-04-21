<?php

// strings and int/floats
var_dump('An example string');

var_dump(12);
var_dump(12.12);

// arrays
var_dump(Array(
	'hello',
	'world',
	12,
));
var_dump(Array(
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
var_dump(new Test);
