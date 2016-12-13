<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:49
 */
class Controller {

    private $model;

    public function __construct($GET) {
        if (isset($GET['action'])) {
            switch ($GET['action']) {
                case 'showUser':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel('{"id":"1"}');
                    break;
            }
        }

    }

    public function display() {

        return '{
  "status":"1",
  "statusText":"OKI DOKI"
}';
    }


}