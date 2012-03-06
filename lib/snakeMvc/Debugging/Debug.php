<?php

namespace snakeMvc\Framework\Debugging;

/**
 * The class for debugging your code
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Debugging
 */
class Debug
{
	private static $colors = Array(
		'string' => '#C00',
		'int'    => '#4E9A06',
		'float'  => '#F57900',
	);
	public static function dump(  )
	{
		$args = func_get_args();
		$colors = (object) self::$colors;

		foreach( $args as $arg )
		{
			$type = gettype($arg);

			if( $type === 'string' )
			{
				# @handle strings
				# @become string 'An example string' (length=17)
				$text = "<small>string</small> <font color=\"".$colors->string."\">'".$arg."'</font> <i>(length=".strlen($arg).")</i>";
			}
			elseif( $type === 'integer' )
			{
				# @handle intergers
				# @become int 12
				$text = "<small>int</small> <font color=\"".$colors->int."\">".$arg."</font>";
			}
			elseif( $type === 'float' || $type === 'double' )
			{
				# @handle floats
				# @become float 12.12
				$text = "<small>float</small> <font color=\"".$colors->float."\">".$arg."</font>";
			}
			elseif( $type === 'array' )
			{
				# @handle arrays
				# @become Array(
				#			[1]		=> 'hello' (string, length = 5),
				#			[2]		=> 'world' (string, length = 5),
				#			['foo'] => 'bar' (string, length = 3),
				#		  )
				$text  = "Array(\n";
				foreach( $arg as $itemKey => $itemValue )
				{
					$text .= "  [".$itemKey."]\t=>  ".self::dump($itemValue, true).",\n";
				}
				$text .= ")";
			}
			elseif( $type === 'object' )
			{
				# @handle objects
				# @become object Test {
				#			protected $hello = string 'default' (length = 7)
				#			private $foo = Array()
				#			public $bar
				#		  }
				$arg = print_r($arg, true);
				preg_match('/(.*?)\sObject\s\((.*)\)/s', $arg, $object);

				list(, $name, $items) = $object;

				echo $name, '<br>', $items;

				$text  = "<small>object</small> Test {\n";
				$text .= "}";
			}

			if( end($args) === true )
				return $text;
			echo '<pre>'.$text.'</pre>';
		}
	}
}
