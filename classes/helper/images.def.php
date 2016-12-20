<?php

/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 19.12.2016
 * Time: 15:55
 */
class Images {

    const validMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];

    public function copyImage($file, $newPath) {
        if (isset($file['tmp_name']) && isset($file['name'])) {
            $tmpPath = $file['tmp_name'];
            $fileType = $this->getImgType($file['name'], $tmpPath);
            if (file_exists($tmpPath) && $fileType !== false) {
                // Den File-Typ noch auslesen
                $newPath = $newPath . '.' . $fileType;
                copy($tmpPath, $newPath);
                return $newPath;
            }
        }
        return false;
    }


    public function getImgType($fileName, $tmpPath) {
        $mimeType = mime_content_type($tmpPath);
        if (in_array($mimeType, self::validMimeTypes)){
            return pathinfo($fileName, PATHINFO_EXTENSION);
        }
        else {
            return false;
        }
    }


}