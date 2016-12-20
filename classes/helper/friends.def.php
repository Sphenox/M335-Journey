<?php

/**
 * Die Klasse welche das ganze Handlich der Friends macht (Friends können leider noch nicht erfasst werden)
 * User: Tim Pfister
 * Date: 16.12.2016
 * Time: 08:58
 */

class Friends {

    /**
     * @param $userId
     * @return array
     */
    public static function getFriendsFromID($userId) {
        $result = Database::getDB()->query('CALL friendsList('.$userId.')');
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