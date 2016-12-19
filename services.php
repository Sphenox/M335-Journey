<?php
/**
 * Die Schnittstelle zum Frontend
 * User: Tim Pfister
 * Date: 13.12.2016
 * Time: 10:42
 */

require_once('classes' . DIRECTORY_SEPARATOR . 'autoload.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'controller.php');

$controller = new Controller($_GET);

echo $controller->display();