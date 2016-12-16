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
CREATE PROCEDURE getAllVisibleLocation
(IN inId INT(11))
BEGIN
	SELECT loc.* FROM journey.users as u , journey.locations as loc
	WHERE u.id = inId
	AND ((loc.FKuser = u.id)
	OR (loc.visible = "all")
	OR (loc.visible = "friends" AND loc.FKuser IN (SELECT u.id FROM journey.users as u RIGHT JOIN journey.friends as f ON ((inId = f.FKuser1 AND f.FKuser2 = u.id ) OR ( inId = f.Fkuser2 AND f.FKuser1 = u.id))WHERE u.id != inId)));
END //
CREATE PROCEDURE getFriendsVisibleLocation
(IN inId INT(11))
BEGIN
SELECT loc.* FROM journey.users as u , journey.locations as loc
	WHERE u.id = inId
	AND ((loc.FKuser = u.id)
	OR (loc.visible = "friends" AND loc.FKuser IN (SELECT u.id FROM journey.users as u RIGHT JOIN journey.friends as f ON ((inId = f.FKuser1 AND f.FKuser2 = u.id ) OR ( inId = f.Fkuser2 AND f.FKuser1 = u.id));
END //
#Goht no nid
CREATE PROCEDURE checkUserLogin
(IN inEmail VARCHAR(255), IN inPassword VARCHAR(255) , OUT outID INT(11))
BEGIN
	SELECT IF(COUNT(u.*) > 0 , 'true' , 'false') , u.id INTO outID FROM journey.users as u
	WHERE u.email = inEmail
	AND u.password = inPassword;
END //
CREATE PROCEDURE checkIfEmailExist
(IN inEmail VARCHAR(255))
BEGIN
	SELECT IF(COUNT(u.*) > 0 , 'true' , 'false') FROM journey.users as u
	WHERE u.email = inEmail;
END //
DELIMITER ;