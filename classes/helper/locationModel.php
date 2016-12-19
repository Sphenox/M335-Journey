<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 14:09
 */
require_once('classes' . DIRECTORY_SEPARATOR . 'defines' . DIRECTORY_SEPARATOR . 'location.def.php');
require_once('classes' . DIRECTORY_SEPARATOR . 'helper' . DIRECTORY_SEPARATOR . 'favorites.php');

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

    public function callGetLocations($userId) {
        if($userId != false){
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

    public function callGetLocation($frontJson){
        $json = json_decode($frontJson);
        $locationObj = new Location();
        if(isset($json->id) && intval($json->id) != 0){
            $result = Database::getDB()->query('CALL getLocation(\''.$json->id.'\');');
            if($result != false){
                foreach($result[0] as $field => $data) {
                    $locationObj->$field = $data;
                    $locationObj->favorite = Favorites::isFavorite($result[0]['FKuser'], $result[0]['id']);
                }
                $response = $locationObj;
                $response->status = '1';
                $response->statusText = '';
            }
            else {
                $response['status'] = '0';
                $response['statusText'] = 'Journey with ID '.$json->id.' does not exists.';
            }
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'JSON is not valid.';
        }
        return $response;
    }
}