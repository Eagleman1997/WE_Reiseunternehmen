<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 22.09.2017
 * Time: 17:13
 */

namespace helpers;

/**
 * Provides access to the use statements in a way the namespaces are defined
 * @author Andreas Martin
 */
class Autoloader
{
    public static function autoload($className) {
        //replace namespace backslash to directory separator of the current operating system
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = $className . '.php';

        if (file_exists($fileName)) {
            include_once($fileName);
        } else {
            return false;
        }
    }
}

spl_autoload_register('helpers\Autoloader::autoload');