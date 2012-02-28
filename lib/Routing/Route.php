<?php

namespace snakeMvc\Framework\Routing;

/**
 * This class represents a Route and handles all things with routes
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Routing
 * @property string $path The path of the route
 * @property array $params All params of the route
 */
class Route
{
	protected $path = '';
	protected $params = Array();

	/**
	 * Set the path and all extra info, as params, defaults, conditions, ect.
	 *
	 * @param string $path The path to this route
	 * @param array $data All extra route data
	 */
	public function __construct( $path, array $data )
	{
		$this->path = $path;

		if( isset($data['params']) )
		{
			$params = $data['params'];

			foreach( $params as $param )
			{
				$this->params[$param] = Array();

				if( isset($data['where'][$param]) )
					$this->params[$param]['condition'] = $data['where'][$param];
				if( isset($data['default'][$param]) )
					$this->params[$param]['default'] = $data['default'][$param];
			}
		}
	}

	/**
	 * Checks if the path matches with the route
	 *
	 * @param string $path The requested pathname
	 * @return boolean $matched True if the route matched the path, false otherwise
	 */
	public function matches( $path )
	{
		$rgx = '/^';

		$rgx .= ( $this->path[0] !== '/'
					? '/'.$this->path
					: $this->path
				);

		foreach( $this->params as $paramPath => $paramInfo )
		{
			if( isset($paramInfo['condition']) )
			{
			}
		}

		$rgx .= '$/';
	}
}
