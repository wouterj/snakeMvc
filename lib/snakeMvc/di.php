<?php

use snakeMvc\Framework\BrowserKit\Template;
use snakeMvc\Framework\TwigExtensions\AssetsExtension;

$container = new \Pimple();

/*
 * Templating
 */
$container['template.class.loader.path'] = ROOT.'app'.DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'templates';
$container['template.class.loader'] = function ($c) {
    return new \Twig_Loader_FileSystem($c['template.class.loader.path']);
};

$container['template.class.config'] = array(
    'debug' => true,
    'strict_variables' => true,
);
$container['template.class'] = function ($c) {
    return new \Twig_Environment($c['template.class.loader'], $c['template.class.config']);
};
$container['template.class'] = $container->extend('template.class', function($class, $c) {
    $class->addExtension(new AssetsExtension());

    return $class;
});

$container['template'] = function ($c) {
    return new Template($c['template.class']);
};
