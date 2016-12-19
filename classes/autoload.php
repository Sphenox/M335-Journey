<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 19.12.2016
 * Time: 14:12
 */

function my_autoloader($class) {
    $filename = lcfirst($class).'.def.php';
    $file = 'classes/defines/'.$filename;

    if (file_exists($file) == false)
    {
        $file = 'classes/helper/'.$filename;
        if(file_exists($file) == false){
            return false;
        }
    }
    require_once($file);
}

spl_autoload_register('my_autoloader');