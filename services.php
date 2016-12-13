<?php
/**
 * Die Schnittstelle zum Frontend
 * User: Tim Pfister
 * Date: 13.12.2016
 * Time: 10:42
 */

require_once('classes' . DIRECTORY_SEPARATOR . 'database.def.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'controller.def.php');

$test = [
    'name' => 'Mustermann',
    'prename' => 'Max',
    'email' => 'max@muster.ch',
    'password' => 'ichmaghonig',
];

Database::getDB()->insert('users', $test);

$controller = new Controller($_GET);

echo $controller->display();