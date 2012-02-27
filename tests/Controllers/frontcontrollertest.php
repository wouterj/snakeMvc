<?php

namespace snakeMvc\Tests\Controllers;
use snakeMvc\Framework\Controller\FrontController;

class FrontControllerTest extends \PHPUnit_Framework_TestCase
{
	protected $frontController = FrontController::getInstance();

	public function testSimpleUrl()
	{
		$this->assertEquals('welcome', $this->frontController->dispatch('/home')->getController());
	}
}
