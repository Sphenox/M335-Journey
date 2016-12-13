<?php

$server = "localhost";
$user = "root";
$password = "";


$db = new mysqli($server, $user, $password);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$db->query("DROP DATABASE journey");

$createDB = "CREATE DATABASE IF NOT EXISTS journey";

if ($db->query($createDB) === TRUE) {
    $db->query("USE journey");

    $DBusers = "CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `prename` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin,
  `userImage` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

    $DBlocations = "CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(255) COLLATE utf8_bin NOT NULL,
  `lng` varchar(255) COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `comment` text COLLATE utf8_bin,
  `createdAt` datetime COLLATE utf8_bin NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` enum('all','friends','none') COLLATE utf8_bin NOT NULL DEFAULT 'all',
  `FKuser` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

    $DBfriends = "CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKuser1` int(11) NOT NULL,
  `FKuser2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";

    $DBfavorites = "CREATE TABLE `favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FKuser` int(11) NOT NULL,
  `FKlocation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";


    if ($db->query($DBusers) !== TRUE) {
        die("Users Tabelle konnte nicht erstellt werden");
    }
    if ($db->query($DBlocations) !== TRUE) {
        die("Locations Tabelle konnte nicht erstellt werden");
    }
    if ($db->query($DBfriends) !== TRUE) {
        die("Friends Tabelle konnte nicht erstellt werden");
    }
    if ($db->query($DBfavorites) !== TRUE) {
        die("Favorites Tabelle konnte nicht erstellt werden");
    }


    echo "Alle Tabellen wurden korrekt eingerichtet.";
    $db->close();
}
else {
    die("DB konnte nicht erstellt werden.");
}

