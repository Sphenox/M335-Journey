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
            switch ($GET['action']) {
                case 'showUser':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel('{"id":"1"}', true);
                    $user = $userModel->getUser();
                    $user['status'] = '1';
                    $user['statusText'] = '';
                    $this->response = json_encode($user);
                    break;
                case 'getJourney':
                    break;
                case 'getJourneys':
                    break;
                case 'registration':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel();
                    $this->response = json_encode($userModel->newUser(file_get_contents('php://input')));
                    break;
                case 'login':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel();
                    $this->response = json_encode($userModel->userLogin(file_get_contents('php://input')));
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