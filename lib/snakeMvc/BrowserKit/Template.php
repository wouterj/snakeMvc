<?php

namespace snakeMvc\Framework\BrowserKit;

/**
 * The object if you use a template
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage BrowserKit
 */
class Template
{
    protected $content;
    protected $parser;

    public function __construct($parser)
    {
        try {
            $this->parser = $parser;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function join($template, $vars = array())
    {
        switch (gettype($vars))
        {
            case 'string' :
                $explodedVars = explode('&', $vars);
                $vars = array();
                foreach ($explodedVars as $var) {
                    $var = explode('=', $var);
                    $vars[$var[0]] = $var[1];
                }
                break;

            case 'array' :
                break;

            default :
                throw new \InvalidArgumentException('The second parameter of Template::join() needs to be an array or a string');
        }

        try {
            return $this->parser->render($template,$vars);
        }
        catch (Twig_Error_Runtime $e) {
            echo $e->getMessage();
        }
    }
}
