<?php

$server = "localhost";
$user = "root";
$password = "";


$db = new mysqli($server, $user, $password);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$create_db = "CREATE DATABASE IF EXISTS journey";

if ($db->query($create_db) === TRUE) {
    $db->query("USE journey");

    $db_users = "CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `user_image` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

    $db_locations  = "CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(255) COLLATE utf8_bin NOT NULL,
  `lng` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin,
  `visible` enum('all','friends','none') COLLATE utf8_bin NOT NULL DEFAULT 'all',
  `FK_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

    $db_friends = "CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FK_user_1` int(11) NOT NULL,
  `FK_user_2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";


    if($db->query($db_users) !== TRUE) {
        die("Users Tabelle konnte nicht erstellt werden");
    }
    if($db->query($db_locations) !== TRUE) {
        die("Locations Tabelle konnte nicht erstellt werden");
    }
    if($db->query($db_friends) !== TRUE) {
        die("Friends Tabelle konnte nicht erstellt werden");
    }

    echo "Alle Tabellen wurden korrekt eingerichtet.";
}
else {
    die("DB konnte nicht erstellt werden.");
}

