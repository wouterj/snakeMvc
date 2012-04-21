<?php

namespace snakeMvc\Framework\Loader;

/**
 * The classloader for third-party applications
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Loader
 */
class ThirdPartyLoader extends AbstractLoader
{
	/**
	 * Get the path of the class file
	 *
	 * @param string $className The name of the class inclusive namespaces
	 * @return string $path The path
	 */
	public function getFilePath( $className )
	{
		$className = ltrim($className, '\\');
		$path = '';
		$namespace = '';
		if ( $lastNsPos = strripos($className, '\\') )
		{
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			
			foreach( $this->namespaces as $name => $path )
				$namespace = str_replace($name, $path, $namespace);
			
			$path = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}

		foreach ( $this->prefixes as $preName => $prePath )
		{
			$className = str_replace($preName, $prePath.'_', $className);
		}

		$path .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

		return $path;
	}
}
