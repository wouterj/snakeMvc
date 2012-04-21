<?php

use snakeMvc\Framework;

/**
 * The registery class
 *
 * @author Wouter J <http://wouterj.nl>
 * @license Creative Commons 3.0 <http://creativecommons.org/licenses/by-sa/3.0/>
 */
class Registery implements \ArrayAccess
{
	protected static $values = array();

	// De basis methods
	public static function set( $key, $value )
	{
		if( self::exists($key) )
			throw new \OutOfBoundsException(sprintf('The key (%s) has already been set, destroy it first', $key));
		self::$values[$key] = $value;
	}

	public static function get( $key )
	{
		if( !self::exists($key) )
			throw new \OutOfBoundsException(sprintf('The key %s does not exists', $key));
		return self::$values[$key];
	}

	public static function destroy( $key )
	{
		unset(self::$values[$key]);
	}

	public static function exists( $key )
	{
		return array_key_exists($key, self::$values);
	}

	// De magic shortcut methods
	public function __get( $key )
	{
		return self::get($key);
	}
	public function __set( $key, $value )
	{
		return self::set($key, $value);
	}
	public function __call( $key, array $arguments = array() )
	{
		if( !is_callable(self::get($key)) )
			throw new \InvalidArgumentException(sprintf('The key %s is not a closure', $key));
		return call_user_func_array(self::get($key), $arguments);
	}
	public function __unset( $key )
	{
		return self::destroy($key);
	}
	public function __isset( $key )
	{
		return self::exists($key);
	}

	// ArrayAccess methods
	public function offsetGet( $key )
	{
		return self::get($key);
	}
	public function offsetSet( $key, $value )
	{
		return self::set($key, $value);
	}
	public function offsetUnset( $key )
	{
		return self::destroy($key);
	}
	public function offsetExists( $key )
	{
		return self::exists($key);
	}
}
