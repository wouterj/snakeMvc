<?php

namespace snakeMvc\Framework\TwigExtensions;

class AssetsExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'assets';
    }

    public function getFunctions()
    {
        return array(
            'asset' => new \Twig_Function_Method($this, 'assetsFunction'),
        );
    }

    public function assetsFunction($url)
    {
        $escapedUrl = ltrim(ltrim($url, '\\'), '/');
        $dirname = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME).'/';
        if (file_exists(ROOT.$escapedUrl)) {
            return $dirname.$url;
        }
        elseif (($path = 'assets/'.$escapedUrl) && file_exists(APP_ROOT.$path)) {
            return $dirname.'/app/'.APP_NAME.'/'.$path;
        }
        else {
            return $url;
        }
    }
}
