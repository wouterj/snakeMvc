<?php

namespace snakeMvc\Framework\Controller;

use snakeMvc\Framework\BrowserKit\Request;

/*
 * The main controller of snakeMvc
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Controller
 */
class Controller
{
    private $request;
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getTemplate()
    {
        return $this->container['template'];
    }

    public function getRequest()
    {
        if ($this->request == null) {
            $this->request = new Request();
        }
        return $this->request;
    }
}
