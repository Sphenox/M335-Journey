<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 16.12.2016
 * Time: 08:58
 */

require_once('classes' . DIRECTORY_SEPARATOR . 'defines' . DIRECTORY_SEPARATOR . 'user.def.php');

class Friends {

    /**
     * @param $id
     * @return array
     */
    public static function getFriendsFromID($id) {
        $result = Database::getDB()->query('CALL friendsList('.$id.')');
        $friendList = [];
        foreach($result as $friend) {
            $user = new User();
            foreach($friend as $field => $data){
                // Jeden Freund in ein User Objekt einfüllen
                $user->$field = $data;
            }
            $friendList[] = $user;
        }
        return $friendList;
    }
}