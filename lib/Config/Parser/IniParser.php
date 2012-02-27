<?php

namespace snakeMvc\Framework\Config\Parser;

require_once __DIR__.'\AbstractParser.php';

/**
 * The parser for ini files
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Config
 */
class IniParser extends AbstractParser
{
	/**
	 * Parse the file and return a parsing array
	 *
	 * @param boolean $getArray Default false, sets it to true if you want a array
	 * @return array|object $file The parse results, array if param is true
	 */
	public function parse( $getArray = false )
	{
		// NOTE this function requires PHP5.3.0, use parse_ini_file for comptability with PHP5
		$file = parse_ini_string($this->file, true);

		foreach( $file as $sectionName => $section )
		{
			foreach( $section as $key => $value )
			{
				$k = explode('.', $key);
				# Handle foo.bar foo.someVar as arrays
				if( count($k) > 1 )
					$file[$sectionName][$k[0]][$k[1]] = $value;

				# Handle foo = { bar = hello, someVar = something } as arrays
				if( strpos($value, '{') === 0 )
				{
					$file[$sectionName][$key] = Array();
					$v = explode(',', substr($value, 1, -1));

					foreach( $v as $vVal )
					{
						$info = explode(':', $vVal);

						$file[$sectionName][$key][trim($info[0])] = trim($info[1]);
					}
				}
			};
		};

		return ($getArray 
					? $file 
					: ((object) $file));
	}
}