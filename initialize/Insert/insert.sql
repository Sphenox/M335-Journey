--Users
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Sinnathurai","Arjuna","arjuna@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","Bist du braun kriegst du Fraun","1-sinnathurai.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Wahl","Florian","flo@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","WUFF MIAU","2-wahl.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Pfister","Tim","tim@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","SIGOI","3-pfister.jpg");
--Friends
INSERT into journey.friends (FKuser1 , FKuser2) VALUES (1,2);
INSERT into journey.friends (FKuser1 , FKuser2) VALUES (2,3);
--Locations
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("62.454646551" , "16.5641434" , "1" , "f", CURTIME(), "all" ,  1);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("62.454646551" , "16.5641434" , "2" , "f", CURTIME(), "none" ,  2);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("62.454646551" , "16.5641434" , "3" , "f", CURTIME(), "friends" ,  1);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("62.454646551" , "16.5641434" , "4" , "f", CURTIME(), "all" ,  2);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("62.454646551" , "16.5641434" , "5" , "f", CURTIME(), "none" ,  3);
--Favorites
INSERT into journey.favorites (FKuser , FKlocation) VALUES (1,1);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (2,1);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (3,1);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (2,2);