<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 13:14
 */
class UserModel {

    private $user;

    /**
     * @return array
     */
    public function getUser() {
        if (is_object($this->user)) {
            return get_object_vars($this->user);
        }
        else {
            if (is_array($this->user)) {
                return $this->user;
            }
            else {
                return ['status' => '0', 'statusText' => 'Could not read User.'];
            }
        }
    }

    /**
     * @param $frontJson
     * @return bool
     */
    public function getUserToDisplay($frontJson) {
        $json = json_decode($frontJson);
        if (isset($_SESSION['userId'])) {
            if (!isset($json->id)) {
                $userId = $_SESSION['userId'];
            }
            else {
                $userId = $json->id;
            }
        }
        else {
            $this->user['status'] = '0';
            $this->user['statusText'] = 'Access denied.';
            return false;
        }
        return $userId;
    }

    /**
     * @param $id
     * @return User | bool
     */
    protected function readUserOnly($id) {
        $user = new User();
        //TODO: PROCEDURE einbauen
        $result = Database::getDB()->query('SELECT * FROM users WHERE id = ' . $id);
        if (!empty($result) && is_array($result)) {
            foreach ($result[0] as $field => $data) {
                $user->$field = $data;
            }
        }
        else {
            $this->user['status'] = '0';
            $this->user['statusText'] = 'User with ID:' . $id . ' was not found.';
            return false;
        }

        return $user;
    }

    /**
     * @param $id
     */
    public function readFullUser($id) {
        $user = $this->readUserOnly($id);
        if ($user !== false) {
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
        // Wurden alle nötigen daten uebergeben?
        if (isset($userInput['email']) && isset($userInput['password']) && isset($userInput['name']) && isset($userInput['prename'])) {
            if (!$this->emailInUse($userInput['email'])) {
                $response['status'] = '0';
                $response['statusText'] = 'This email is already in use.';
                return $response;
            }
            $dbInsert['password'] = hash('sha512', $userInput['password']);
            $dbInsert['email'] = $userInput['email'];
            $dbInsert['name'] = $userInput['name'];
            $dbInsert['prename'] = $userInput['prename'];
            $dbReturn = Database::getDB()->insert('users', $dbInsert);
            if ($dbReturn) {
                $userId = Database::getDB()->getLastInsertId();
                $_SESSION['userId'] = $userId;
                // Das Profilbild am richtigen Ort abspeichern
                $fileUpload = new Images();
                $filePath = $fileUpload->copyImage($_FILES['file'], 'files/user/' . $userId);
                if ($filePath != false) {
                    // Den Pfad zum Bild in der DB speichern.
                    Database::getDB()->update('users', ['userImage' => $filePath], 'id = ' . $userId);
                    $response['status'] = '1';
                    $response['statusText'] = 'User is successfully created.';
                }
                else {
                    // Den User wieder löschen, da das Bild nicht gespeichert wurde
                    Database::getDB()->delete('DELETE FROM users WHERE id = ' . $userId);
                    $response['status'] = '0';
                    $response['statusText'] = 'There was an error while saving the image.';
                }
            }
            else {
                $response['status'] = '0';
                $response['statusText'] = 'There was an error while creating the user.';
            }
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'The transferred data is not correct.';
        }
        return $response;
    }

    /**
     * @param $email
     * @return bool
     */
    public function emailInUse($email) {
        $result = Database::getDB()->query('CALL checkIfEmailExist(\'' . $email . '\');');
        return $result[0]['emailCheck'];
    }

    public function userLogin($userInput) {
        // Damit beim Login eine neue Session_ID generiert wird.
        session_regenerate_id();
        $userInput = json_decode($userInput);
        if (isset($userInput->email) && isset($userInput->password)) {
            $email = Database::getDB()->escape($userInput->email);
            $password = hash('sha512', $userInput->password);
            $result = Database::getDB()->query('CALL checkUserLogin(\'' . $email . '\',\'' . $password . '\')');
            if (intval($result[0]['id']) != 0 || intval($result[0]['id']) != -1) {
                $_SESSION['userId'] = $result[0]['id'];
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