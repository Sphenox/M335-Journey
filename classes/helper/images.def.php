<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 19.12.2016
 * Time: 15:55
 */
class Images {

    private $UserImagePath = 'files/user/';

    public function copyUserImage($file, $newName) {
        if(isset($file['tmp_name']) && isset($file['name'])){
            $tmpPath = $file['tmp_name'];
            if(file_exists($tmpPath)){
                $newPath = $this->UserImagePath . $newName .'.'.$this->getImgType($file['name']);
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