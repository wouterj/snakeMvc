<?php

namespace snakeMvc\Framework\Routing;

/**
 * This class represents a Route and handles all things with routes
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Routing
 * @property string $name The name of the Route
 * @property string $path The path of the route
 * @property string $action The controller and action for the route
 * @property array $params All params of the route
 * @property string $method The request method of the route
 * @property string $_rgx The matching regex for checking if route matches with path
 */
class Route
{
    protected $name = '';
    protected $path = '';
    protected $action = '';
    protected $params = Array();
    protected $method = '';
    protected $_rgx = '';

    /**
    * Set the path and all extra info, as params, defaults, conditions, ect.
    *
    * @param string $path The path to this route
    * @param array $data All extra route data
    */
    public function __construct($path, array $data)
    {
        $this->path = $path;
        $this->action = $data['to'];
        $this->method = $data['method'];
        $this->name = $data['name'];

        if (isset($data['params'])) {
            $params = $data['params'];

            foreach ($params as $param => $optional) {
                $this->params[$param] = array(
                    'optional' => $optional,
                );

                if (isset($data['where'][$param])) {
                    $this->params[$param]['condition'] = $data['where'][$param];
                }
                if (isset($data['default'][$param])) {
                    $this->params[$param]['default'] = $data['default'][$param];
                }
            }
        }
    }

    /**
    * Checks if the path matches with the route
    *
    * @param string $path The requested pathname
    * @return boolean $matched True if the route matched the path, false otherwise
    */
    public function matches($path, $method)
    {
        if ($this->_rgx == '') {
            $this->makeRgx();
        }

        if ((strtoupper($this->method) == $method) && preg_match($this->_rgx, $path, $params)) {
            array_shift($params);
            $keys = array_keys($this->params);
            reset($keys);

            foreach ($params as $p) {
                $this->params[current($keys)]['value'] = $p;
                next($keys);
            }

            return true;
        }

        return false;
    }

    public function getParams()
    {
        $params = Array();

        foreach ($this->params as $param) {
            if (!isset($param['value']) || $param['value'] == '') {
                $param['value'] = ( isset($param['default'])
                                        ? $param['default']
                                        : '' 
                                    );
            }
            $params[] = $param['value'];
        }

        return $params;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return reset(explode('::', $this->action));
    }

    public function getAction()
    {
        return end(explode('::', $this->action));
    }

    /**
     * Make the regex, if not already maked
     *
     * @access protected
     */
    protected function makeRgx()
    {
        $rgx = '';

        $rgx .= ( $this->path[0] !== '/'
                    ? '/'.preg_replace('/\/*{.*?}\/*/', '', $this->path)
                    : preg_replace('/\(*\/*{.*?}\/*\)*/', '', $this->path)
                );

        foreach ($this->params as $paramPath => $paramInfo) {
            if (isset($paramInfo['condition'])) {
                $block = '(['.$paramInfo['condition'].']*?)';
            }
            else {
                $block = '(.*?)';
            }

            if ($paramInfo['optional']) {
                $rgx .= '(?:/'.$block.')*';
            }
            else {
                $rgx .= '/'.$block;
            }
        }

        $this->_rgx = '/^'.str_replace('/', '\/', $rgx).'\/?$/';
    }
}
