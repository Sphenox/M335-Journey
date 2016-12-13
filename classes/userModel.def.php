<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 13:14
 */
require_once ('classes' . DIRECTORY_SEPARATOR . 'user.def.php');
class UserModel {

    private $user;

    /**
     * @return array
     */
    public function getUser() {
        return get_object_vars($this->user);
    }

    public function __construct($json, $fullUser = false) {
        $jsonObj= json_decode($json);
        if(is_object($jsonObj)){
            if($fullUser){
                $this->getFullUser($jsonObj->id);
            }
        }
    }

    protected function getOnlyUser($id) {
        $user = new User();
        //TODO: PROCEDURE einbauen
        $result = Database::getDB()->query('SELECT * FROM users WHERE id = '.$id);
        foreach($result[0] as $field => $data) {
            $user->$field = $data;
        }

        return $user;
    }

    public function getFullUser($id) {
        $user = $this->getOnlyUser($id);
        require_once ('classes' . DIRECTORY_SEPARATOR . 'locationModel.def.php');
        $locModel = new LocationModel();
        $user->journeys = $locModel->getLocationsFromUser($id);
        //$user->friends = getFriends($id);
        //$user->favorites =
        $this->user = $user;
    }

    public function getFriends($id){
        $result = Database::getDB()->query();
    }


    public function newUser() {
        

    }

}