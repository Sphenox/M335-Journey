<?php

/**
 * Klasse welche das Erfassen und ausgeben von den Location/Journeys handelt.
 * User: Tim Pfister
 * Date: 13.12.2016
 * Time: 14:09
 */
class LocationModel {

    /**
     * @param $userId
     * @return array
     */
    public function getLocationsFromUser($userId) {
        $result = Database::getDB()->query('CALL getAllLocationFromUser(' . $userId . ')');
        $locations = [];
        foreach ($result as $location) {
            $locationObj = new Location();
            foreach ($location as $field => $data) {
                $locationObj->$field = $data;
                $locationObj->favorite = Favorites::isFavorite($userId, $location['id']);
            }
            $locations[] = $locationObj;
        }
        return $locations;
    }

    private function getAllVisibleLocations($userId) {
        $result = Database::getDB()->query('CALL getAllVisibleLocation(' . $userId . ')');
        $locations = [];
        foreach ($result as $location) {
            $locationObj = new Location();
            foreach ($location as $field => $data) {
                $locationObj->$field = $data;
                $locationObj->favorite = Favorites::isFavorite($userId, $location['id']);
            }
            $locations[] = $locationObj;
        }
        return $locations;
    }

    public function callGetLocations($userId) {
        if ($userId != false) {
            $response['uploads'] = $this->getLocationsFromUser($userId);
            $response['status'] = '1';
            $response['statusText'] = '';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'User id is not set.';
        }
        return $response;
    }

    public function callGetAllLocations() {
        if (isset($_SESSION['userId'])) {
            $response['uploads'] = $this->getAllVisibleLocations($_SESSION['userId']);
            $response['status'] = '1';
            $response['statusText'] = '';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'User id is not set.';
        }
        return $response;
    }

    public function callGetLocation($frontJson) {
        $json = json_decode($frontJson);
        $locationObj = new Location();
        if (isset($json->id) && intval($json->id) != 0) {
            $result = Database::getDB()->query('CALL getLocation(\'' . $json->id . '\');');
            if ($result != false) {
                foreach ($result[0] as $field => $data) {
                    $locationObj->$field = $data;
                    if (isset($_SESSION['userId'])) {
                        $locationObj->favorite = Favorites::isFavorite($_SESSION['userId'], $result[0]['id']);
                    }
                    else {
                        $locationObj->favorite = false;
                    }
                }
                $response = $locationObj;
                $response->status = '1';
                $response->statusText = '';
            }
            else {
                $response['status'] = '0';
                $response['statusText'] = 'Journey with ID ' . $json->id . ' does not exists.';
            }
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'JSON is not valid.';
        }
        return $response;
    }

    /**
     * @param $userInput
     */
    public function newLocation($userInput) {
        // Sind alle Daten korrekt übergeben worden?
        if (isset($userInput['lat']) && isset($userInput['lng']) && isset($userInput['comment'])) {
            // Die benötigten Daten abfüllen, damit nichts falsches in die DB geschrieben wird.
            $dbInsert['lat'] = $userInput['lat'];
            $dbInsert['lng'] = $userInput['lng'];
            $dbInsert['comment'] = $userInput['comment'];
            if (isset($_SESSION['userId'])) {
                $dbInsert['FKuser'] = intval($_SESSION['userId']);
            }
            $dbReturn = Database::getDB()->insert('locations', $dbInsert);
            if ($dbReturn) {
                $locId = Database::getDB()->getLastInsertId();
                $fileUpload = new Images();
                $filePath = $fileUpload->copyImage($_FILES['file'], 'files/location/' . $locId);
                if ($filePath != false) {
                    // Den Pfad in der DB speichern
                    Database::getDB()->update('locations', ['image' => $filePath], 'id = ' . $locId);
                    $response['status'] = '1';
                    $response['statusText'] = 'Journey is successfully created.';
                }
                else {
                    // Location wieder löschen, da das Bild nicht gespeichert wurde.
                    Database::getDB()->delete('DELETE FROM locations WHERE id = ' . $locId);
                    $response['status'] = '0';
                    $response['statusText'] = 'There was an error while saving the image.';
                }
            }
            else {
                $response['status'] = '0';
                $response['statusText'] = 'There was an error while creating the Journey.';
            }
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'The transferred data is not correct.';
        }
        return $response;
    }
}