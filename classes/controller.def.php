<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:49
 */
class Controller {

    private $model;
    private $response = '{
                                   "status":"1",
                                   "statusText":"OKI DOKI"
                                 }';

    public function __construct($GET) {
        session_start();
        if (isset($GET['action'])) {
            // Die Daten, welche wir vom Frontend bekommen
            $frontJson = file_get_contents('php://input');

            switch ($GET['action']) {
                case 'showUser':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel();
                    $userId = $userModel->getUserToDisplay($frontJson);
                    if($userId !== false) {
                        $userModel->getFullUser($userId);
                    }
                    $user = $userModel->getUser();
                    $this->response = json_encode($user);
                    break;
                case 'getJourney':
                    break;
                case 'getJourneys':
                    break;
                case 'getFavorites':
                    break;
                case 'registration':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel();
                    $this->response = json_encode($userModel->newUser($frontJson));
                    break;
                case 'login':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel();
                    $this->response = json_encode($userModel->userLogin($frontJson));
                    break;
                case 'logout':
                    session_unset();
                    $this->response = '{
                                   "status":"1",
                                   "statusText":"User is logged out now."
                                 }';
                    break;
                case 'isLoggedIn':
                    if (isset($_SESSION['userid'])) {
                        $this->response = '{"isLoggedIn": "true"}';
                    }
                    else {
                        $this->response = '{"isLoggedIn": "false"}';
                    }
                    break;
                default:
                    $this->response = '{
                                   "status":"1",
                                   "statusText":"OKI DOKI"
                                 }';
                    break;
            }
        }

    }

    public function display() {

        return $this->response;
    }


}