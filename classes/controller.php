<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:49
 */
require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'userModel.php');

class Controller {

    private $model;
    private $response;

    public function __construct($GET) {
        session_start();
        if (isset($GET['action'])) {
            // Die Daten, welche wir vom Frontend bekommen
            $frontJson = file_get_contents('php://input');

            switch ($GET['action']) {
                case 'showUser':
                    $userModel = new UserModel();
                    $userId = $userModel->getUserToDisplay($frontJson);
                    if ($userId !== false) {
                        $userModel->readFullUser($userId);
                    }
                    $this->response = $userModel->getUser();
                    break;
                case 'getJourney':
                    break;
                case 'getJourneys':
                    $userModel = new UserModel();
                    $userId = $userModel->getUserToDisplay($frontJson);
                    require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'locationModel.php');
                    $locModel = new LocationModel();
                    $this->response = $locModel->callGetLocations($userId);
                    break;
                case 'getFavorites':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'favorites.php');
                    $userModel = new UserModel();
                    $userId = $userModel->getUserToDisplay($frontJson);
                    $fav = new Favorites();
                    $this->response = $fav->callGetFavorites($userId);
                    break;
                case 'toggleFavorite':
                    require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'favorites.php');
                    $fav = new Favorites();
                    $this->response = $fav->toggleFavorite($frontJson);
                    break;
                case 'registration':
                    $userModel = new UserModel();
                    $this->response = $userModel->newUser($frontJson);
                    break;
                case 'login':
                    $userModel = new UserModel();
                    $this->response = $userModel->userLogin($frontJson);
                    break;
                case 'logout':
                    session_unset();
                    $this->response['status'] = '1';
                    $this->response['statusText'] = 'User is logged out Now';
                    break;
                case 'isLoggedIn':
                    if (isset($_SESSION['userid'])) {
                        $this->response['isLoggedIn'] = 'true';
                    }
                    else {
                        $this->response['isLoggedIn'] = 'false';
                    }
                    break;
                default:
                    $this->response['status'] = '1';
                    $this->response['statusText'] = 'That action has not been defined yet.';
                    break;
            }
        }

    }

    public function display() {

        return json_encode($this->response);
    }


}