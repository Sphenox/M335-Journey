DELIMITER //
CREATE PROCEDURE friendsList
(IN inId INT(11))
BEGIN
	 SELECT u.* FROM journey.users as u RIGHT JOIN journey.friends as f ON ((inId = f.FKuser1 AND f.FKuser2 = u.id ) OR ( inId = f.Fkuser2 AND f.FKuser1 = u.id))
	WHERE u.id != inId;	 
END //
CREATE PROCEDURE favoritesList
(IN inId INT(11))
BEGIN
	SELECT loc.* FROM journey.users as u , journey.favorites as fav , journey.locations as loc
	WHERE fav.FKuser = u.id
	 AND fav.fklocation = loc.id
    AND u.id = inId;
END //
CREATE PROCEDURE getAllLocationFromUser
(IN inId INT(11))
BEGIN
	SELECT loc.* FROM journey.users as u , journey.locations as loc
	WHERE loc.FKuser = u.id
	AND u.id = inId;
END //
CREATE PROCEDURE getVisibleLocation
(IN inId INT(11), IN visibility VARCHAR(10))
BEGIN
	SELECT loc.* FROM journey.users as u , journey.locations as loc
	WHERE loc.FKuser = u.id
	AND u.id = inId;
END //
CREATE PROCEDURE getUser
(IN email VARCHAR(255), IN password VARCHAR(255))
BEGIN
	SELECT loc.* FROM journey.users as u , journey.locations as loc
	WHERE loc.FKuser = u.id
	AND u.id = inId;
END //
DELIMITER ;