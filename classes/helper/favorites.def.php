<?php
/**
 *
 * User: Anwender
 * Date: 13.12.2016
 * Time: 11:32
 */
class Favorites {

    public static function getFavoritesFromId($userId) {
        $result = Database::getDB()->query('CALL favoritesList(' . $userId . ')');
        $favoritesList = [];
        foreach ($result as $favorite) {
            $location = new Location();
            foreach ($favorite as $field => $data) {
                // Jeder Favorit in ein Location Objekt einfüllen
                $location->$field = $data;
                $location->favorite = self::isFavorite($userId, $location->id);
            }
            $favoritesList[] = $location;
        }
        return $favoritesList;
    }

    /**
     * @param $userId
     * @param $locId
     * @return mixed
     */
    public static function isFavorite($userId, $locId) {
        $result = Database::getDB()->query('CALL checkIfFavoured(' . $userId . ', ' . $locId . ')');
        return $result[0]['isFavoured'];
    }

    /**
     * @param $frontJson
     * @return array
     */
    public function toggleFavorite($frontJson) {
        $jsonObj = json_decode($frontJson);
        if (isset($_SESSION['userId']) && isset($jsonObj->id) && intval($jsonObj->id) != 0) {
            $userId = intval($_SESSION['userId']);
            $locId = intval($jsonObj->id);
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

    public function callGetFavorites($userId) {
        if ($userId !== false) {
            $response['uploads'] = self::getFavoritesFromId($userId);
            $response['status'] = '1';
            $response['statusText'] = '';
        }
        else {
            $response['status'] = '0';
            $response['statusText'] = 'User id is not set.';
        }

        return $response;
    }

}