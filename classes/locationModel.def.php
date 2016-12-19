<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 13.12.2016
 * Time: 14:09
 */
require_once ('classes' . DIRECTORY_SEPARATOR . 'location.def.php');
require_once ('classes' . DIRECTORY_SEPARATOR . 'favorites.def.php');

class LocationModel {


    public function getLocationsFromUser($userId) {
        $result = Database::getDB()->query('CALL getAllLocationFromUser('.$userId.')');
        $locations = [];
        foreach ($result as $location) {
            $locationObj = new Location();
            foreach ($location as $field => $data) {
                $locationObj->$field = $data;
                $locationObj->favorite = Favorites::isFavorite($userId,$location['id']);
            }
            $locations[] = $locationObj;
        }
        return $locations;
    }
}