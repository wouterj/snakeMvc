<?php

namespace snakeMvc\Framework;
use snakeMvc\Framework\Loader\ClassLoader;
use snakeMvc\Framework\Controller\FrontController;

ini_set('xdebug.var_display_max_depth', 5);

require_once 'lib/Loader/ClassLoader.php';

/*
 * Define some constants
 */
define('ROOT', __DIR__.DIRECTORY_SEPARATOR);
define('LIB_ROOT', __DIR__.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR);


/*
 * Register the class loader
 */
$classloader = new ClassLoader;

$classloader->setNamespaces(array(
	'snakeMvc\Framework' => 'lib\snakeMvc',
	'snakeMvc\Bundle' => 'app',
));

$classloader->register();

$thirdPartyLoader = new ThirdPartyLoader;

$thirdPartyLoader->setPrefixes(array(
	'Twig_' => 'Twig\lib\Twig'
));

$thirdPartyLoader->setBaseDir(__DIR__.'/vendor/');

$thirdPartyLoader->register();

/*
 * the main code
 */
$uri = $_SERVER['REQUEST_URI'];
if( ($pos = strripos($uri, 'index.php')) )
	$uri = substr($uri, $pos + 9);
else
	$uri = '/';

$frontController = FrontController::getInstance();

$frontController->dispatch($uri);
