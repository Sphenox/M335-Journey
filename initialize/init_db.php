<?php


//---------------------------------------
// HIER DIE DATEN ANPASSEN FALLS NÖTIG
// Beschreibung der Variablen:
// $server   -> der Servername, auf welchem die Datenbank läuft standart: localhost
// $user     -> der Benutzername, mit welchem man Zugriff auf die Datenbank hat standart: root
// $passwort -> das Passwort für den Benutzer
// $DBName   -> der Name für die Datenbank standart: journey
//---------------------------------------
$server = "localhost";
$user = "root";
$password = "";
$DBName = "journey";
//---------------------------------------
// ENDE DER ANZUPASSENDEN DATEN
//---------------------------------------

$db = new mysqli($server, $user, $password);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$createDB = "CREATE DATABASE IF NOT EXISTS ".$DBName;

if ($db->query($createDB) === TRUE) {
    $db->query("USE ".$DBName);

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

    // Das Ganze insert File in die DB einspielen. (Inserts)
    $lines = file(__DIR__ . '\Insert\insert.sql');
    $sqlStmnt = '';
    foreach ($lines as $line) {
        // Falls es ein Kommentar oder eine Leere Zeile ist
        if (substr($line, 0, 2) == '--' || $line == '') {
            continue;
        }
        $sqlStmnt .= $line;
        // Falls die Linie ein ; am schluss hat, den befehl ausführen.
        if (substr(trim($line), -1, 1) == ';') {
            $db->query($sqlStmnt);

            $sqlStmnt = '';
        }
    }
    // Procedures einbinden
    $db->multi_query(file_get_contents(__DIR__ . '\Procedure\procedure.sql'));

    $db->close();
}
else {
    die("DB konnte nicht erstellt werden.");
}

