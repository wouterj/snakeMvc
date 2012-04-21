<?php

namespace snakeMvc\Framework\BrowserKit;

/**
 * The request with all data from the server, user and browser
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage BrowserKit
 */
class Request
{
    protected $session;
    protected $cookie;
    protected $server;
    protected $get;
    protected $post;

    /**
     * Make up Lazy Loading properties
     */
    public function __construct()
    {
        $this->session = function() {
            return $_SESSION;
        };
        $this->cookie = function() {
            return $_COOKIE;
        };
        $this->server = function() {
            return $_SERVER;
        };
        $this->get = function() {
            return $_GET;
        };
        $this->post = function() {
            return $_POST;
        };
    }

    public function __get($key)
    {
        if (isset($this->$key)) {
            $superglobal = $this->$key;
            return $superglobal();
        }
        throw new \InvalidArgumentException(sprintf('The property %s::%s does not exists', __CLASS__, $key));
    }
}
