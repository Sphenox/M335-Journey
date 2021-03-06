<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:49
 */
class Controller {

    private $response;

    /**
     * Controller constructor.
     * @param $GET
     */
    public function __construct($GET) {
        session_start();
        if (isset($GET['action'])) {
            // Die Daten, welche wir vom Frontend bekommen
            $frontJson = file_get_contents('php://input');
            // Das UserModel Objekt instanzieren
            $userModel = new UserModel();
            $userId = $userModel->getUserToDisplay($frontJson);

            if ($userId != false || $GET['action'] == 'login' || $GET['action'] == 'registration') {
                switch ($GET['action']) {
                    case 'showUser':
                        if ($userId !== false) {
                            $userModel->readFullUser($userId);
                        }
                        $this->response = $userModel->getUser();
                        break;
                    case 'getJourney':
                        $locModel = new LocationModel();
                        $this->response = $locModel->callGetLocation($frontJson);
                        break;
                    case 'getJourneys':
                        $locModel = new LocationModel();
                        $this->response = $locModel->callGetLocations($userId);
                        break;
                    case 'getAllJourneys':
                        $locModel = new LocationModel();
                        $this->response = $locModel->callGetAllLocations();
                        break;
                    case 'newJourney':
                        $locModel = new LocationModel();
                        $this->response = $locModel->newLocation($_POST);
                        break;
                    case 'getFavorites':
                        $fav = new Favorites();
                        $this->response = $fav->callGetFavorites($userId);
                        break;
                    case 'toggleFavorite':
                        $fav = new Favorites();
                        $this->response = $fav->toggleFavorite($frontJson);
                        break;
                    case 'registration':
                        $this->response = $userModel->newUser($_POST);
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

    /**
     * @return string
     */
    public function display() {

        return json_encode($this->response);
    }


}