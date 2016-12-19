<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 19.12.2016
 * Time: 15:55
 */
class Images {

    public function copyImage($file, $newPath) {
        if(isset($file['tmp_name']) && isset($file['name'])){
            $tmpPath = $file['tmp_name'];
            if(file_exists($tmpPath)){
                // Den File-Typ noch auslesen
                $newPath = $newPath.'.'.$this->getImgType($file['name']);
                copy($tmpPath, $newPath);
                return $newPath;
            }
        }
        return false;
    }


    public function getImgType($fileName) {
        return pathinfo($fileName,PATHINFO_EXTENSION);
    }
}