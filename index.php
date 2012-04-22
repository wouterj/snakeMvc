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
require_once 'lib/vendor/Pimple/lib/Pimple.php';

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
$classloader->setPrefixes(array(
    'Twig_' => 'lib\vendor\Twig\lib\Twig'
));

$classloader->register();

/*
 * Define some more constants
 */
$config = new IniParser(file_get_contents(ROOT.'/config/config.ini'));
$config = $config->parse();

define('APP_NAME', $config->framework->app->active);
define('APP_ROOT', ROOT.'app/'.APP_NAME.'/');

/*
 * The dependency injenction code
 */
require_once LIB_ROOT.'snakeMvc/di.php';

/*
 * the front controller code
 */
$uri = preg_split('/snakeMvc\/(index.php)*/', $_SERVER['REQUEST_URI']);

if (empty($uri[1])) {
	$uri[1] = '/';
}

$frontController = new FrontController($container);

$frontController->dispatch($uri[1]);
