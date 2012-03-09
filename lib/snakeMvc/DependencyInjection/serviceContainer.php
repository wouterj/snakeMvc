<?php

namespace snakeMvc\Framework\DependencyInjenction;

/**
 * The Main service container of snakeMvc
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Dependency Injection
 */
class ServiceContainer implements \ArrayAccess
{
	protected $values;
	protected $shared;

	public function __construct( array $values = array() )
	{
		$this->values = $values;
		$this->shared = array();
	}

	public function get( $key )
	{
		if( !array_key_exists($key, $this->values) )
			throw new \InvalidArgumentException(sprintf('%s has not been set', $key));

		$value = (array_key_exists($key, $this->shared)
					? $this->shared[$key]
					: $this->values[$key]
			   );

		if( is_callable($value ) )
			return $value; # it's a service!
		return $value; # it's a parameter
	}

	public function set( $key, $value, $shared = false )
	{
		$this->values[$key] = $value;
		if( $shared )
			$this->shared[$key] = $value;
	}

	public function destroy( $key, $hard = true )
	{
		unset($this->shared[$key]);
		if( $hard ) unset($this->values[$key]);
	}

	public function exists( $key )
	{
		return isset($this->values[$key]);
	}

	public function __call( $key, array $args = array() )
	{
		$service = $this->get(strtolower(substr($key, 3)));
		if( !is_callable($service) )
			throw new \InvalidArgumentException(sprintf('The service %s is not a callable service', $key));
		return call_user_func_array($service, $args); 
	}

	/*
	 * Magic methods
	 */
	public function __get( $key )
	{
		return $this->get($key);
	}
	public function __set( $key, $value )
	{
		return $this->set($key, $value);
	}
	public function __isset( $key )
	{
		return $this->exists($key);
	}
	public function __unset( $key )
	{
		return $this->destroy($key);
	}

	/*
	 * ArrayAccess methods
	 */
	public function offsetGet( $key )
	{
		$service = $this->get($key);
		if( is_callable($service) )
			return $service();
		return $service;
	}
	public function offsetSet( $key, $value )
	{
		return $this->set($key, $value);
	}
	public function offsetExists( $key )
	{
		return $this->exists($key);
	}
	public function offsetUnset( $key )
	{
		return $this->destroy($key);
	}
}
