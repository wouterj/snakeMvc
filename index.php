<?php

namespace snakeMvc\Framework;
use snakeMvc\Framework\Loader\ClassLoader;
use snakeMvc\Framework\Loader\ThirdPartyLoader;
use snakeMvc\Framework\Config\Parser\IniParser;
use snakeMvc\Framework\Controller\FrontController;

// for debugging routes
// ini_set('xdebug.var_display_max_depth', 5);

chdir(__DIR__);

require_once 'lib/snakeMvc/Loader/ClassLoader.php';
require_once 'lib/vendor/Twig/lib/Twig/Autoloader.php';

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

/* And the Twig classloader */
\Twig_Autoloader::register();

/*
 * Define some more constants
 */
$config = parse_ini_file(ROOT.'/config/config.ini', true);

define('APP_NAME', $config['apps']['active']);
define('APP_ROOT', ROOT.'app/'.APP_NAME.'/');

/*
 * the main code
 */
$uri = preg_split('/snakeMvc\/(index.php)*/', $_SERVER['REQUEST_URI']);

if( empty($uri[1]) )
	$uri[1] = '/';

$frontController = FrontController::getInstance();

$frontController->dispatch($uri[1]);
