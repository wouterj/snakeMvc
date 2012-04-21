<?php

namespace snakeMvc\Framework\BrowserKit;

/**
 * This class is the response of the action to the view
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage BrowserKit
 */
class Response
{
    protected $content;
    protected $contentType;

    /**
     * Make a new Response
     */
    public function __construct($content, $contentType = 'html')
    {
        $this->content = $content;
        $this->contentType = $contentType;
    }

    public function show()
    {
        $ctHeader = (strpos('/', $this->contentType) === false
                        ? 'text/'.$this->contentType
                        : $this->contentType
                    );
        header('Content-Type: '.$ctHeader);

        echo $this->content;
    }
}
