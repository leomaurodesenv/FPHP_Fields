<?php

/**
 * Autoloading Standard - PSR (http://www.phptherightway.com/)
 *
 * See my autoload: 
 * [PHP Classes](http://www.phpclasses.org/fphp_loader)
 * [Github](https://github.com/leomaurodesenv/FPHP_Loader/)
 */

function autoload($className){
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($namespace)).DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
	$root = str_replace('\\', DIRECTORY_SEPARATOR, realpath(dirname(__FILE__))).DIRECTORY_SEPARATOR;
	require $root.$fileName;
}

spl_autoload_register('autoload');

?>