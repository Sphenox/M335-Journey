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
        if (isset($GET['action'])) {
            switch ($GET['action']) {
                case 'showUser':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'userModel.def.php');
                    $userModel = new UserModel('{"id":"1"}', true);
                    $user = $userModel->getUser();
                    $user['status'] = '1';
                    $user['statusText'] = 'Fuck that';
                    $this->response = json_encode($user);
                    break;
                case 'registration':
                    $this->response = '{
                                   "status":"1",
                                   "statusText":"REGISCHTRATION IST FERTISCH, NE";
                                 }';
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