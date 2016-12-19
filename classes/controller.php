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
            // Das UserModel Objekt instanzieren
            $userModel = new UserModel();
            $userId = $userModel->getUserToDisplay($frontJson);

            if ($userId != false) {
                switch ($GET['action']) {
                    case 'showUser':
                        if ($userId !== false) {
                            $userModel->readFullUser($userId);
                        }
                        $this->response = $userModel->getUser();
                        break;
                    case 'getJourney':
                        require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'locationModel.php');
                        $locModel = new LocationModel();
                        $this->response = $locModel->callGetLocation($frontJson);

                        break;
                    case 'getJourneys':
                        require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'locationModel.php');
                        $locModel = new LocationModel();
                        $this->response = $locModel->callGetLocations($userId);
                        break;
                    case 'newJourney':
                        require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'locationModel.php');
                        $locModel = new LocationModel();
                        break;
                    case 'getFavorites':
                        require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'favorites.php');
                        $fav = new Favorites();
                        $this->response = $fav->callGetFavorites($userId);
                        break;
                    case 'toggleFavorite':
                        require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'favorites.php');
                        $fav = new Favorites();
                        $this->response = $fav->toggleFavorite($frontJson);
                        break;
                    case 'registration':
                        $this->response = $userModel->newUser($frontJson);
                        break;
                    case 'login':
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
            else {
                $this->response = $userModel->getUser();
            }
        }

    }

    public function display() {

        return json_encode($this->response);
    }


}