<?php

namespace snakeMvc\Framework\Loader;

use snakeMvc\Framework\Loader\AbstractLoader;

require_once 'AbstractLoader.php';

/**
 * This class is the autoloader for all classes in this framework
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Loader
 */
class ClassLoader extends AbstractLoader
{
	/**
	 * Get the path of the class file, this function use {@link https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md the PSR-0 standards}
	 *
	 * @param string $className The name of the class inclusive namespaces
	 * @return string $path The path
	 */
	public function getFilePath($className)
	{
		$className = ltrim($className, '\\');
		$path = '';
		$namespace = '';

        foreach ($this->classes as $name => $path) {
            if ($className == $name) {
                $className = $path;
            }
        }

		if ($lastNsPos = strripos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			
			foreach ($this->namespaces as $name => $path) {
				$namespace = str_replace($name, $path, $namespace);
            }
			
			$path = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}

		foreach ($this->prefixes as $prefixName => $prefixPath) {
			$className = str_replace($prefixName, $prefixPath.'_', $className);
		}

		$path .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

		return $path;
	}
}
