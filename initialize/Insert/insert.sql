--Users
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Sinnathurai","Arjuna","arjuna@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","Bist du braun kriegst du Fraun","files/user/1-sinnathurai.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Wahl","Florian","flo@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","WUFF MIAU","files/user/2-wahl.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("Pfister","Tim","tim@journey.ch","d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db","SIGOI","files/user/3-pfister.jpg");
Insert into journey.users (name, prename , email , password , description , userImage) VALUES ("admin","admin","admin@journey.ch","3cedbe825e44d66e896dc40b185d94ba146f4a82c6c464663bde4ba420bbb0bdb2aed7b91835363d7cbc1ca6e5b56fe7aaca86692a245b5b23baa02a2b43fc5a","SIGOI","files/user/4-admin.jpg");
--Locations
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("46.0237" , "7.7481" , "files/location/1.jpg" , "Black n' White", CURTIME(), "all" ,  1);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("38.9072" , "-77.0369" , "files/location/2.jpg" , "Found a wild canary..", CURTIME(), "all" ,  2);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("35.6895" , "139.6917" , "files/location/3.jpg" , "Tokyo in da Hooouuuse", CURTIME(), "all" ,  3);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("38.7253" , "-9.15" , "files/location/4.jpg" , "Lissabon, a beatiful city", CURTIME(), "all" ,  4);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("51.5112" , "-.1198" , "files/location/5.jpg" , "Its raining, but I still love it.", CURTIME(), "all" ,  4);
Insert into journey.locations (lat , lng ,image , comment, createdAt ,visible ,FKuser) VALUES ("60.192059" , "24.945831" , "files/location/6.jpg" , "Helsinki, just Amazing (The University of Art and Design)", CURTIME(), "all" ,  4);
--Favorites
INSERT into journey.favorites (FKuser , FKlocation) VALUES (1,3);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (2,1);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (3,1);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (2,2);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (4,3);
INSERT into journey.favorites (FKuser , FKlocation) VALUES (4,1);
