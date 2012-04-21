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
    private static $colors = array(
        'string' => '#C00',
        'int'    => '#4E9A06',
        'float'  => '#F57900',
        'bool' => '#75507B',
        'null' => '#3465A4',
        'resource' => '#53A434',
    );

    public static function dump()
    {
        $args = func_get_args();
        $colors = (object) self::$colors;

        foreach ($args as $arg) {
            $type = gettype($arg);

            if ($type === 'string') {
                # @handle strings
                # @become string 'An example string' (length=17)
                $text = "<small>string</small> <font color=\"".$colors->string."\">'".$arg."'</font> <i>(length=".strlen($arg).")</i>";
            }
            elseif ($type === 'integer') {
                # @handle intergers
                # @become int 12
                $text = "<small>int</small> <font color=\"".$colors->int."\">".$arg."</font>";
            }
            elseif ($type === 'float' || $type === 'double') {
                # @handle floats
                # @become float 12.12
                $text = "<small>float</small> <font color=\"".$colors->float."\">".$arg."</font>";
            }
            elseif ($type === 'boolean') {
                # @handle booleans
                # @become boolean true
                $bools = array('true' => true, 'false' => false);
                $text = "<small>boolean</small> <font color=\"".$colors->bool."\">".array_search($arg, $bools)."</font>";
            }
            elseif ($type === 'NULL') {
                # @handle NULL
                # @become null
                $text = "<font color=\"".$colors->null."\">null</font>";
            }
            elseif ($type === 'array') {
                # @handle arrays
                # @become Array(
                #			[1]		=> 'hello' (string, length = 5),
                #			[2]		=> 'world' (string, length = 5),
                #			['foo'] => 'bar' (string, length = 3),
                #		  )
                $text  = "Array(\n";
                foreach ($arg as $itemKey => $itemValue) {
                    $text .= "  [".$itemKey."]\t=>  ".self::dump($itemValue, true).",\n";
                }
                $text .= ")";
            }
            elseif ($type === 'object') {
                # @handle objects
                # @become object Test {
                #			protected $hello = string 'default' (length = 7)
                #			private $foo = Array()
                #			public $bar
                #		  }
                $a = print_r($arg, true);
                preg_match('/(.*?)\sObject\s\((.*)\)/s', $a, $object);

                list(, $name, $items) = $object;

                preg_match_all('/\[(.*?)(?::(.*?))*\]\s=>\s(.*?)(?=(?:\[|$))/s', $items, $itms);

                $text  = "<small>object</small> ".$name." {\n";

                // add variables
                foreach ($itms[0] as $id => $item) {
                    $text .= "\t".( $itms[2][$id] !== ''
                                        ? $itms[2][$id]
                                        : 'public'
                                    )." $".$itms[1][$id];

                    if (!preg_match('/^\s*?$/', $itms[3][$id])) {
                        if (preg_match('/Array.(.)/s', $itms[3][$id])) {
                            $itms[3][$id] = 'Array()';
                        }
                        $text .= ' = '.($itms[3][$id] !== 'Array()'
                                            ? self::dump($itms[3][$id], true)
                                            : trim($itms[3][$id])
                                       );
                    }
                    $text .= ";\n";
                }

                // add methods
                $methods = get_class_methods($arg);
                foreach ($methods as $method) {
                    $text .= "\n\tpublic function ".$method."();\n";
                }
                $text .= "}";
            }
            elseif ($type == 'resource') {
                $text = '<small>resource</small> <font color="'.$colors->resource.'">'.get_resource_type($arg)."</font>";
            }
            else {
                $text = '<small>'.$type.'</small> '.$arg;
            }

            if (end($args) === true && count($args) > 1) {
                return $text;
            }
            echo '<pre>'.$text.'</pre>';
        }
    }
}
