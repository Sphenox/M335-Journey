--Users
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Sinnathurai","Arjuna","arjuna1997@windowslive.com","3efb213f649117caaec085d7c32e4c39","Bist du braun kriegst du Fraun","1-sinnathurai.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Wahl","Florian","wafl@hotmail.com","cb0094eb894989b7d6b4a470f539d57d","WUFF MIAU","2-wahl.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Pfister","Tim","timpfister@gmail.com","dd21032795b405428e39761382adbb2e","SIGOI","3-pfister.jpg");
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