<?php
/**
 *
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:32
 */
require_once('classes' . DIRECTORY_SEPARATOR . 'location.def.php');

class Favorites {

    public static function getFavoritesFromId($userId) {
        $result = Database::getDB()->query('CALL favoritesList('.$userId.')');
        $favoritesList = [];
        foreach($result as $favorite) {
            $location = new Location();
            foreach($favorite as $field => $data){
                // Jeder Favorit in ein Location Objekt einfüllen
                $location->$field = $data;
            }
            $favoritesList[] = $location;
        }
        return $favoritesList;
    }

}