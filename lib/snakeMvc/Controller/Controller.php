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

    public function getRequest()
    {
        if ($this->request == null) {
            $this->request = new Request();
        }
        return $this->request;
    }
}
