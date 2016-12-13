<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 13:14
 */
require_once ('classes' . DIRECTORY_SEPARATOR . 'user.def.php');
class UserModel {

    private $users = [];

    public function __construct($json) {
        $jsonObj= json_decode($json);
        if(is_object($jsonObj)){
            $this->getUser($jsonObj->id);
        }
    }

    public function getUser($id) {
        $user = new User();
        //TODO: PROCEDURE einbauen
        $data = Database::getDB()->query('SELECT * FROM users WHERE id = '.$id);
        echo '<pre>';
        print_r($user);
        echo '</pre>';
    }

}