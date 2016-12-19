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
        $result = Database::getDB()->query('CALL favoritesList(' . $userId . ')');
        $favoritesList = [];
        foreach ($result as $favorite) {
            $location = new Location();
            foreach ($favorite as $field => $data) {
                // Jeder Favorit in ein Location Objekt einfüllen
                $location->$field = $data;
            }
            $favoritesList[] = $location;
        }
        return $favoritesList;
    }

    /**
     * @param $frontJson
     * @return array
     */
    public function toggleFavorite($frontJson) {
        $jsonObj = json_decode($frontJson);
        if (isset($_SESSION['userId']) && isset($jsonObj->locId) && intval($jsonObj->locId) != 0) {
            $userId = intval($_SESSION['userId']);
            $locId = intval($jsonObj->locId);
            $result = Database::getDB()->query('CALL checkIfFavoured(' . $userId . ', ' . $locId . ')');

            // Mit String vergleichen weil es aus der DB kommt und nicht mit einem BOOL vergleicht werden kann.
            if ($result[0]['isFavoured'] === 'true') {
                $response = $this->removeFavorite($userId, $locId);
            }
            else {
                $response = $this->setFavorite($userId, $locId);
            }
        }
        else if (!isset($_SESSION['userId'])) {
            $response['status'] = '0';
            $response['statusText'] = 'You have to be logged in to set favorites.';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'Not a valid Journey-ID.';
        }
        return $response;
    }

    /**
     * @param $userId
     * @param $locId
     * @return array
     */
    private function setFavorite($userId, $locId) {
        $result = Database::getDB()->insert('favorites', ['FKuser' => $userId, 'FKlocation' => $locId]);
        if ($result === true) {
            $response['status'] = '1';
            $response['statusText'] = 'Favorite has been set.';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'There was an unknown error while setting the Favorite.';
        }
        return $response;
    }

    /**
     * @param $userId
     * @param $locId
     * @return array
     */
    private function removeFavorite($userId, $locId) {
        $result = Database::getDB()->delete('DELETE FROM favorites WHERE FKuser = ' . $userId . ' AND FKlocation = ' . $locId . ';');
        if ($result === true) {
            $response['status'] = '1';
            $response['statusText'] = 'Favorite has been removed.';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'There was an unknown error while removing the Favorite.';
        }
        return $response;
    }

}