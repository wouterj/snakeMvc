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

    public function __construct()
    {
        try {
            $loader = new \Twig_Loader_FileSystem(ROOT.'app'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'templates');
            $this->parser = new \Twig_Environment($loader, array(
                'debug' => true,
                'strict_variables' => true,
            ));
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
