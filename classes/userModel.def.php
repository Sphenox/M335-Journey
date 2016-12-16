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

    /**
     * @param $userInput
     * @return array
     */
    public function newUser($userInput) {
        $userInput = json_decode($userInput);
        // Wurden alle nötigen daten uebergeben?
        if (isset($userInput->email) && isset($userInput->password) && isset($userInput->name) && isset($userInput->prename)) {
            if (!$this->emailInUse($userInput->email)) {
                $return['status'] = '0';
                $return['statusText'] = 'This email is already in use.';
                return $return;
            }
            $userInput->password = md5($userInput->password);
            $response = Database::getDB()->insert('users', $userInput);
            if ($response) {
                $return['status'] = '1';
                $return['statusText'] = 'User is successfully created.';
            }
            else {
                $return['status'] = '0';
                $return['statusText'] = 'There was an error while creating the user.';
            }
        }
        else {
            $return['status'] = '0';
            $return['statusText'] = 'The transferred data is not correct.';
        }
        return $return;
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailInUse($email) {
        $result = Database::getDB()->query('CALL checkIfEmailExist(\''.$email.'\');');
        return $result[0]['emailCheck'];
    }

    public function userLogin($userInput) {
        $userInput = json_decode($userInput);
        if(isset($userInput->email) && isset($userInput->password) ){
            $email = Database::getDB()->escape($userInput->email);
            $password = Database::getDB()->escape(md5($userInput->password));
            $result = Database::getDB()->query('CALL checkUserLogin(\''.$email.'\',\''.$password.'\')');
            if(intval($result[0]['id']) != 0 || intval($result[0]['id']) != -1){
                $_SESSION["userId"] = $result[0]['id'];
                $return['status'] = '1';
                $return['statusText'] = 'Successfull login.';
            }
            else {
                $return['status'] = '0';
                $return['statusText'] = 'Username or password are wrong!';
            }
        }
        else {
            $return['status'] = '0';
            $return['statusText'] = 'The transferred data is not correct.';
        }
        return $return;
    }

}