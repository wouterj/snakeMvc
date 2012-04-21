<?php

namespace snakeMvc\Framework\Loader;

/**
 * The abstract loader class
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Loader
 */
abstract class AbstractLoader
{
	/**
	 * Predefined namespaces and their paths
	 * 
	 * @var array
	 */
	protected $namespaces = array();

	/**
	 * Predefined prefixes and their paths
	 *
	 * @var array
	 */
	protected $prefixes = array();

    /**
     * Predefined classnames and their paths
     *
     * @var array
     */
    protected $classes = array();

	/**
	 * The basedirecotry for including
	 *
	 * @var string
	 */
	protected $base = '';

    /**
     * Set predefined classnames into a path
     *
     * @param array|string $name The name of the classes, if it's a array the key is the name and the value the path
     * @param string $path The path of the class
     */
    public function setClasses($name, $path = null)
    {
        if (is_array($name) && $path === null) {
            $this->classes = $name;
        }
        else {
            $this->classes[$name] = $path;
        }
    }

	/**
	 * Set predefined prefixes if $name is a array, and add prefix if $name is a string
	 *
	 * @param array|string $name All the prefixes if is array, if this is a string the prefixes name
	 * @param string $path The path of the prefix
	 */
	public function setPrefixes( $name, $path = null )
	{
		if ( (is_array($name)) && ($path === null) )
			$this->prefixes = $name;
		else
			$this->prefixes[$name] = $path;
	}

	/**
	 * Set predefined namespaces if $name is a array, and add a namespace if $name is a string
	 *
	 * @param array|string $name All the namespaces if is array, if this is a string the namespace name
	 * @param string $path The path of the namespace, default null
	 */
	public function setNamespaces( $name, $path = null )
	{
		if ( (is_array($name)) && ($path === null) )
			$this->namespaces = $name;
		else
			$this->namespaces[$name] = $path;
	}

	/**
	 * Set the base directory
	 *
	 * @param string $dir This dir must be absolute
	 */
	public function setBaseDir( $dir )
	{
		if( !in_array(substr($dir, -1), Array('/', '\\')) )
			$dir .= DIRECTORY_SEPARATOR;
		$this->base = $dir;
	}

	/**
	 * Get the base directory
	 *
	 * @return string $dir The directory
	 */
	public function getBaseDir()
	{
		return $this->base;
	}

	/**
	 * Register the classloader as a spl autolader
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'loadClass'), true);
	}

	/**
	 * The actuall loading of classes
	 *
	 * @param string $className The name of the path inclusive namespaces
	 */
	public function loadClass( $className )
	{
		$file = $this->getFilePath($className);

		if( file_exists($file) )
		{
			require_once $this->base.$file;
		}
	}

	abstract public function getFilePath( $className );
}
