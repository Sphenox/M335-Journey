<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 13:14
 */
require_once('classes' . DIRECTORY_SEPARATOR . 'user.def.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'friends.def.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'favorites.def.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'locationModel.def.php');

class UserModel {

    private $user;

    /**
     * @return array
     */
    public function getUser() {
        return get_object_vars($this->user);
    }

    /**
     * UserModel constructor.
     * @param string $json
     * @param bool $fullUser
     */
    public function __construct($json = '', $fullUser = false) {
        $jsonObj = json_decode($json);
        if (is_object($jsonObj) && isset($jsonObj->id)) {
            if ($fullUser) {
                $this->getFullUser($jsonObj->id);
            }
        }
    }

    /**
     * @param $id
     * @return User
     */
    protected function getOnlyUser($id) {
        $user = new User();
        //TODO: PROCEDURE einbauen
        $result = Database::getDB()->query('SELECT * FROM users WHERE id = ' . $id);
        foreach ($result[0] as $field => $data) {
            $user->$field = $data;
        }

        return $user;
    }

    /**
     * @param $id
     */
    public function getFullUser($id) {
        $user = $this->getOnlyUser($id);
        $locModel = new LocationModel();
        $user->journeys = $locModel->getLocationsFromUser($id);
        $user->friends = Friends::getFriendsFromID($id);
        $user->favorites = Favorites::getFavoritesFromId($id);
        $this->user = $user;

    }


    public function newUser($userInput) {
        $userInput = json_decode($userInput);
    }

}