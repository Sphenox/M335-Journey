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
        if(is_object($this->user)){
            return get_object_vars($this->user);
        }
        else {
            return $this->user;
        }
    }

    /**
     * @param $frontJson
     * @return bool
     */
    public function getUserToDisplay($frontJson) {
        if(empty($frontJson) && isset($_SESSION['userId'])){
            $userId = $_SESSION['userId'];
        }
        else if (!empty($frontJson)) {
            $json = json_decode($frontJson);
            if(isset($json->id) && intval($json->id)){
                $userId = $json->id;
            }
            else {
                $this->user['status'] = '0';
                $this->user['statusText'] = 'JSON is not valid';
            }
        }
        else {
            $this->user['status'] = '0';
            $this->user['statusText'] = 'No User selected';
            return false;
        }
        return $userId;
    }

    /**
     * @param $id
     * @return User | bool
     */
    protected function getOnlyUser($id) {
        $user = new User();
        //TODO: PROCEDURE einbauen
        $result = Database::getDB()->query('SELECT * FROM users WHERE id = ' . $id);
        if(!empty($result) && is_array($result)){
            foreach ($result[0] as $field => $data) {
                $user->$field = $data;
            }
        }
        else {
            $this->user['status'] = '0';
            $this->user['statusText'] = 'User with ID:'.$id.' was not found.';
            return false;
        }

        return $user;
    }

    /**
     * @param $id
     */
    public function getFullUser($id) {
        $user = $this->getOnlyUser($id);
        if($user !== false){
            $locModel = new LocationModel();
            $user->journeys = $locModel->getLocationsFromUser($id);
            $user->friends = Friends::getFriendsFromID($id);
            $user->favorites = Favorites::getFavoritesFromId($id);
            $this->user = get_object_vars($user);
            $this->user['status'] = '1';
            $this->user['statusText'] = '';
        }
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
            $userInput->password = hash('sha512', $userInput->password);
            $response = Database::getDB()->insert('users', $userInput);
            if ($response) {
                $_SESSION['userId'] = Database::getDB()->getLastInsertId();
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
            $password = hash('sha512',$userInput->password);
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