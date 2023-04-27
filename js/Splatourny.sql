-- create and select the database
DROP DATABASE IF EXISTS Splatourney;
CREATE DATABASE Splatourney;
USE Splatourney;

-- create the tables for the database-------------------------------------------

-- ------
-- table for a basic user
CREATE TABLE user_type (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  description      	VARCHAR(20)    	NOT NULL,
  isActive      	BOOLEAN        	DEFAULT 1,
  PRIMARY KEY (ID)
);


-- details about a user
CREATE TABLE splatourney_user(
  ID        		INT         	NOT NULL   AUTO_INCREMENT,
  user_type_id          INT    		NOT NULL,
  email_address         VARCHAR(255)   	NOT NULL,
  username		VARCHAR(60)	NOT NULL,
  password              VARCHAR(60)    	NOT NULL,
  first_name            VARCHAR(60)    	NOT NULL,
  last_name             VARCHAR(60)    	NOT NULL,
  switch_friend_code    VARCHAR(12),
  switch_username	VARCHAR(10),
  splashtag		VARCHAR(15),
  discord_username 	VARCHAR(60),
  discord_client_secret VARCHAR(60),
  isActive      	BOOLEAN     	DEFAULT 1,
  display_name		BOOLEAN		DEFAULT 0,
  PRIMARY KEY (ID),
  UNIQUE INDEX emailAddress (email_address),
  UNIQUE INDEX discord_username (discord_username),
  UNIQUE INDEX discord_client_secret (discord_client_secret),
  UNIQUE INDEX switch_friend_code (switch_friend_code),
  UNIQUE INDEX splashtag (splashtag),
  UNIQUE INDEX username (username)
);
-- ------


-- ------

-- list of maps in splatoon
CREATE TABLE map (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  description      	VARCHAR(20)    	NOT NULL,
  image_link		VARCHAR(200)	NOT NULL,
  isActive      	BOOLEAN        	DEFAULT 1,
  PRIMARY KEY (ID)
);

-- list of modes in splatoon
CREATE TABLE mode (
  ID			INT		NOT NULL	AUTO_INCREMENT,
  description		VARCHAR(200)	NOT NULL,
  image_link		VARCHAR(200)	NOT NULL,
  PRIMARY KEY (ID)
);
-- ------

-- member of a team
CREATE TABLE team_member_list (
  ID			INT		NOT NULL AUTO_INCREMENT,
  user_id		INT		NOT NULL,
  team_id		INT 		NOT NULL,
  isActive              BOOLEAN     	DEFAULT 1,
  PRIMARY KEY (ID)
);

-- table for a team
CREATE TABLE team(
  ID        		INT         	NOT NULL   AUTO_INCREMENT,
  captain_user_id       INT    		NOT NULL,
  team_name      	VARCHAR(255)   	NOT NULL,
  team_image_link	VARCHAR(5000),
  isActive      	BOOLEAN     	DEFAULT 1,
  PRIMARY KEY (ID)
);


-- ------

-- details of a tournament
CREATE TABLE tournament (
    ID                                  INT 		NOT NULL AUTO_INCREMENT,
    tournament_owner_id                 INT,
    tournament_organizer_name           VARCHAR(255)    NOT NULL,
    tournament_type_id                  INT,
    tournament_banner_link              VARCHAR(5000)   Default 'default.png',
    tournament_name                     VARCHAR(255),
    tournament_date                     DATETIME,
    tournament_registration_deadline    DATETIME,
    tournament_about                    LONGTEXT,
    tournament_prizes                   LONGTEXT,
    tournament_contact                  LONGTEXT,
    tournament_rules                    LONGTEXT,
    isActive                            BOOLEAN        	DEFAULT 1,
    PRIMARY KEY (ID)
); 


-- a bracket of a tournament
CREATE TABLE bracket (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  tournament_id         INT    		NOT NULL,
  tournament_type_id    INT      	Default 1,
  bracket_name          VARCHAR(255)    Default '',
  number_of_rounds      INT		Default 1,
  PRIMARY KEY (ID)
);  

	-- game for maplist
CREATE TABLE bracket_map_list (
	ID		INT		NOT NULL	AUTO_INCREMENT,
	bracket_id	INT		NOT NULL,
	round		INT		NOT NULL,
	isActive      	BOOLEAN     	DEFAULT 1,	
	PRIMARY KEY (ID)
);

-- maps for the map list
CREATE TABLE bracket_map_list_map(
  ID        		INT         	NOT NULL   AUTO_INCREMENT,
  bracket_match_list_id	INT		NOT NULL,
  game_number		INT		NOT NULL,
  map_id   		INT    		DEFAULT 0,
  mode_id      		INT   		DEFAULT 0,
  isActive      	BOOLEAN     	DEFAULT 1,	
  PRIMARY KEY (ID)
);
	  

-- a match in a tournament 
CREATE TABLE bracket_match (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  tournament_id         INT    		NOT NULL,
  bracket_id            INT		NOT NULL,
  team_one_id  		INT             Default NULL,				
  team_two_id		INT             Default NULL,
  round			INT		NOT NULL,
  team_one_wins         INT		DEFAULT 0,
  team_two_wins		INT		DEFAULT 0,
  wins_needed_to_win    INT             NOT NULL,
  winner_team_id	INT             DEFAULT 0,
  match_number		INT		NOT NULL,
  isActive      	BOOLEAN     	DEFAULT 1,
  PRIMARY KEY (ID)
);

-- a chat for a match 
CREATE TABLE chat (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  match_id     		INT    		NOT NULL,
  isActive      	BOOLEAN     	DEFAULT 1,
  PRIMARY KEY (ID)
);

-- a chat for a match 
CREATE TABLE chat_message (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  chat_id     		INT    		NOT NULL,
  user_id		INT		NOT NULL,
  message      		VARCHAR(255)    NOT NULL,
  date_sent		DATETIME	DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID)
);

-- an admin of the tournament
CREATE TABLE tournament_admin (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  tournament_id         INT    		NOT NULL,
  user_id      		INT        	NOT NULL,
  PRIMARY KEY (ID)
);

-- table for a team in a tournament
CREATE TABLE tournament_team(
  ID        		INT         	NOT NULL   AUTO_INCREMENT,
  tournament_id   	INT    		NOT NULL,
  team_id      		INT   		NOT NULL,
  seed                  INT             NOT NULL,
  isActive      	BOOLEAN     	DEFAULT 1,
  PRIMARY KEY (ID)
);

-- results from a tournament
CREATE TABLE tournament_result (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  tournament_id         INT    		NOT NULL,
  bracket_id            INT		NOT NULL,
  team_id      		INT        	NOT NULL,
  result		INT		NOT NULL,
  PRIMARY KEY (ID)
);

-- list of types of tournaments
CREATE TABLE tournament_type (
  ID        		INT            	NOT NULL   AUTO_INCREMENT,
  description      	VARCHAR(20)    	NOT NULL,
  isActive      	BOOLEAN        	DEFAULT 0,
  PRIMARY KEY (ID)
);
-- ------  

-- ----------------------------------------------------------------------------- 

-- inserting default data for tables-------------------------------------------- 


INSERT INTO chat(match_id)
VALUES(1),
	(2),
	(3),
	(4),
	(5),
	(6),
	(7),
	(8),
	(9);

INSERT INTO chat_message(chat_id, user_id, message)
VALUES(1, 1,'Hi, could you please add me?'),
	(1, 2,'Sure, do you want us to make a room?'),
	(1,1, 'No, we got it'),
	(1,1, 'The password is 0248'),
	(1,2, 'I sent the friend request'),
	(1,2, 'That is everyone, glhf'),
	(1,1,'thanks, you too');


INSERT INTO mode(description, image_link)
VALUES('Zones', 'images/modes/zones.png'),
	('Tower Control', 'images/modes/tower_control.png'),
	('Rainmaker', 'images/modes/rainmaker.png'),
	('Clam Blitz', 'images/modes/clam_blitz.png'),
	('Turf War', 'images/modes/turf_war.png');
    
INSERT INTO splatourney_user(user_type_id, email_address, username, password, first_name, last_name, switch_friend_code, switch_username, splashtag, discord_username, display_name)
VALUES(2, 'admin@admin.com', 'admin', 'password', 'adminf', 'adminl','123456789123', 'adminsu', 'adminsu#1234', 'admindu#1234', '1'),
	(1, 'user@user.com', 'user', 'password', 'userf', 'userl','222444777888', 'useru', 'usersu#1234', 'userdu#1234', '1'),
        (1, 'steve@mail.com', 'steveT', 'password', 'Steve', 'Tod','111444777456', 'steveruser', 'steverusersu#1234', 'steveruserdu#1234', '0'),
        (1, 'Jay@mail.com', 'JayJ', 'password', 'Jay', 'Johnson','777444777888', 'jayuser', 'jayusersu#1234', 'jayuserdu#1234', '0'),
        (1, 'Mary@mail.com', 'MaryK', 'password', 'Mary', 'Kruger','222333999444', 'maryuser', 'maryusersu#1234', 'maryuserdu#1234', '1');
    
INSERT INTO team(captain_user_id, team_name, team_image_link)
VALUES(1,'The Admin Team', 'Siege_art.png'),
	(2,'The User Gang', 'team_test_2.jpg'),
    (3,'Jelly Squids', 'team_test_2.jpg'),
	(3,'Siege', 'team_test_2.jpg'),
	(3,'Bonesaw', 'team_test_2.jpg'),
	(3,'King Maker', 'team_test_2.jpg'),
	(3,'20 Pew Pew', 'team_test_2.jpg'),
	(3,'Day Old Sushi', 'team_test_2.jpg'),
	(3,'FTW', 'team_test_2.jpg'),
	(3,'Not FTW', 'team_test_2.jpg'),
	(3,'Komodo', 'team_test_2.jpg'),
	(3,'Miracle', 'team_test_2.jpg'),
	(3,'Moo Moo Squids', 'team_test_2.jpg'),
	(3,'Literal Communism', 'team_test_2.jpg'),
	(3,'A Fucking Rock', 'team_test_2.jpg'),
	(3,'Timmy and the Crusaders ', 'team_test_2.jpg');

INSERT INTO team_member_list(team_id, user_id)
VALUES (1,1),
	(1,2),
        (1,3),
        (1,4),
        (2,5),
        (3,2);
    
INSERT INTO tournament(tournament_owner_id, tournament_organizer_name, tournament_type_id, tournament_name, tournament_banner_link, tournament_date, tournament_registration_deadline, tournament_about, tournament_prizes, tournament_contact, tournament_rules)
VALUES(1,'admin gaming', 1, 'admins tournament', 'test_tournament_1.png', '2023-03-20 03:00:00', '2023-03-10 03:00:00', 'this is the about information of the test tournament', 'the prize for winning this tournament is the privlige to pet my cat', 'email us at admin@admin.com', 'the rules of the tournament are to win the tournament' ),
	(1,'admin gaming', 2, 'admins tournament 2', 'test_tournament_2.png','2023-06-20 03:00:00', '2022-06-19 03:00:00', 'this is the about information of the test tournament', 'the prize for winning this tournament is the privlige to pet my cat', 'email us at admin@admin.com', 'the rules of the tournament are to win the tournament' ),
	(1,'admin gaming', 1, 'admins tournament 3', 'test_tournament_3.png','2023-06-16 03:00:00', '2023-06-15 03:00:00', 'this is the about information of the test tournament', 'the prize for winning this tournament is the privlige to pet my cat', 'email us at admin@admin.com', 'the rules of the tournament are to win the tournament' );
	
INSERT INTO map(description, image_link)
VALUES('Brinewater Springs', 'images/maps/Brinewater_Springs.png'),
	('Eeltail Alley', 'images/maps/Eeltail_Alley.png'),
	('Flounder Heights', 'images/maps/Flounder_Heights.png'),
	('Hagglefish Market', 'images/maps/Hagglefish_Market.png'),
	('Hammerhead Bridge', 'images/maps/Hammerhead_Bridge.png'),
	('Inkblot Art Academy', 'images/maps/Inkblot_Art_Academy.png'),
	('Mahi-Mahi Resort', 'images/maps/Mahi-Mahi_Resort.png'),
	('Mako Mart', 'images/maps/Mako_Mart.png'),
	('Manta Maria', 'images/maps/Manta_Maria.png'),
	('Mincemeat Metalworks', 'images/maps/Mincemeat_Metalworks.png'),
	('Museum_d'' Alfonsino', 'images/maps/Museum_d''Alfonsino.png'),
	('Scorch Gorge', 'images/maps/Scorch_Gorge.png'),
	('Sturgeon Shipyard', 'images/maps/Sturgeon_Shipyard.png'),
	('Um''ami_Ruins', 'images/maps/Um''ami_Ruins.png'),
	('Undertow Spillway', 'images/maps/Undertow_Spillway.png'),
	('Wahoo World', 'images/maps/Wahoo_World.png');
	
	

	

INSERT INTO bracket_map_list(bracket_id, round, isActive)
VALUES(1,1,1),
	(1,2,1),
	(1,3,1),
	(1,4,1),
	(1,5,0),
	(1,6,0),
	(1,7,0),
	(1,8,0),
	(1,9,0),
	(1,10,0),
	(1,11,0),

	(2,1,1),
	(2,2,1),
	(2,3,1),
	(2,4,1),
	(2,5,0),
	(2,6,0),
	(2,7,0),
	(2,8,0),
	(2,9,0),
	(2,10,0),
	(2,11,0),

        (3,1,1),
	(3,2,0),
	(3,3,0),
	(3,4,0),
	(3,5,0),
	(3,6,0),
	(3,7,0),
	(3,8,0),
	(3,9,0),
	(3,10,0),
	(3,11,0);

INSERT INTO bracket_map_list_map(bracket_match_list_id, game_number, map_id, mode_id)
VALUES(1,1,4,2),
	(1,2,3,1),
	(1,3,5,4),
	(1,4,7,3),
	(1,5,4,2),
	(1,6,3,1),
	(1,7,4,4),
	(1,8,0,0),
	(1,9,0,0),
	(1,10,0,0),
	(1,11,0,0),
	
	(2,1,7,3),
	(2,2,4,2),
	(2,3,3,1),
	(2,4,0,0),
	(2,5,0,0),
	(2,6,0,0),
	(2,7,0,0),
	(2,8,0,0),	
	(2,9,0,0),
	(2,10,0,0),
	(2,11,0,0),
	
	(3,1,4,4),
	(3,2,1,3),
	(3,3,5,2),
	(3,4,5,2),
	(3,5,5,2),
	(3,6,0,0),
	(3,7,0,0),
	(3,8,0,0),
	(3,9,0,0),
	(3,10,0,0),
	(3,11,0,0),
	
	(4,1,8,1),
	(4,2,3,4),
	(4,3,5,3),
	(4,4,4,2),
	(4,5,1,1),
	(4,6,2,4),
	(4,7,1,3),
	(4,8,7,2),
	(4,9,3,1),
	(4,10,0,0),
	(4,11,0,0),
	
	(5,1,0,0),
	(5,2,0,0),
	(5,3,0,0),
	(5,4,0,0),
	(5,5,0,0),
	(5,6,0,0),
	(5,7,0,0),
	(5,8,0,0),
	(5,9,0,0),
	(5,10,0,0),
	(5,11,0,0),
	
	(6,1,0,0),
	(6,2,0,0),
	(6,3,0,0),
	(6,4,0,0),
	(6,5,0,0),
	(6,6,0,0),
	(6,7,0,0),
	(6,8,0,0),
	(6,9,0,0),
	(6,10,0,0),
	(6,11,0,0),
	
	(7,1,0,0),
	(7,2,0,0),
	(7,3,0,0),
	(7,4,0,0),
	(7,5,0,0),
	(7,6,0,0),
	(7,7,0,0),
	(7,8,0,0),
	(7,9,0,0),
	(7,10,0,0),
	(7,11,0,0),
	
	(8,1,0,0),
	(8,2,0,0),
	(8,3,0,0),
	(8,4,0,0),
	(8,5,0,0),
	(8,6,0,0),
	(8,7,0,0),
	(8,8,0,0),
	(8,9,0,0),
	(8,10,0,0),
	(8,11,0,0),
	
	(9,1,0,0),
	(9,2,0,0),
	(9,3,0,0),
	(9,4,0,0),
	(9,5,0,0),
	(9,6,0,0),
	(9,7,0,0),
	(9,8,0,0),
	(9,9,0,0),
	(9,10,0,0),
	(9,11,0,0),
	
	(10,1,0,0),
	(10,2,0,0),
	(10,3,0,0),
	(10,4,0,0),
	(10,5,0,0),
	(10,6,0,0),
	(10,7,0,0),
	(10,8,0,0),
	(10,9,0,0),
	(10,10,0,0),
	(10,11,0,0),
	
	(11,1,0,0),
	(11,2,0,0),
	(11,3,0,0),
	(11,4,0,0),
	(11,5,0,0),
	(11,6,0,0),
	(11,7,0,0),
	(11,8,0,0),
	(11,9,0,0),
	(11,10,0,0),
	(11,11,0,0),
	
	(12,1,0,0),
	(12,2,0,0),
	(12,3,0,0),
	(12,4,0,0),
	(12,5,0,0),
	(12,6,0,0),
	(12,7,0,0),
	(12,8,0,0),
	(12,9,0,0),
	(12,10,0,0),
	(12,11,0,0),
	
	(13,1,0,0),
	(13,2,0,0),
	(13,3,0,0),
	(13,4,0,0),
	(13,5,0,0),
	(13,6,0,0),
	(13,7,0,0),
	(13,8,0,0),	
	(13,9,0,0),
	(13,10,0,0),
	(13,11,0,0),
	
	(14,1,0,0),
	(14,2,0,0),
	(14,3,0,0),
	(14,4,0,0),
	(14,5,0,0),
	(14,6,0,0),
	(14,7,0,0),
	(14,8,0,0),
	(14,9,0,0),
	(14,10,0,0),
	(14,11,0,0),
	
	(15,1,0,0),
	(15,2,0,0),
	(15,3,0,0),
	(15,4,0,0),
	(15,5,0,0),
	(15,6,0,0),
	(15,7,0,0),
	(15,8,0,0),
	(15,9,0,0),
	(15,10,0,0),
	(15,11,0,0),
	
	(16,1,0,0),
	(16,2,0,0),
	(16,3,0,0),
	(16,4,0,0),
	(16,5,0,0),
	(16,6,0,0),
	(16,7,0,0),
	(16,8,0,0),
	(16,9,0,0),
	(16,10,0,0),
	(16,11,0,0),
	
	(17,1,0,0),
	(17,2,0,0),
	(17,3,0,0),
	(17,4,0,0),
	(17,5,0,0),
	(17,6,0,0),
	(17,7,0,0),
	(17,8,0,0),
	(17,9,0,0),
	(17,10,0,0),
	(17,11,0,0),
	
	(18,1,0,0),
	(18,2,0,0),
	(18,3,0,0),
	(18,4,0,0),
	(18,5,0,0),
	(18,6,0,0),
	(18,7,0,0),
	(18,8,0,0),
	(18,9,0,0),
	(18,10,0,0),
	(18,11,0,0),
	
	(19,1,0,0),
	(19,2,0,0),
	(19,3,0,0),
	(19,4,0,0),
	(19,5,0,0),
	(19,6,0,0),
	(19,7,0,0),
	(19,8,0,0),
	(19,9,0,0),
	(19,10,0,0),
	(19,11,0,0),
	
	(20,1,0,0),
	(20,2,0,0),
	(20,3,0,0),
	(20,4,0,0),
	(20,5,0,0),
	(20,6,0,0),
	(20,7,0,0),
	(20,8,0,0),
	(20,9,0,0),
	(20,10,0,0),
	(20,11,0,0),
	
	(21,1,0,0),
	(21,2,0,0),
	(21,3,0,0),
	(21,4,0,0),
	(21,5,0,0),
	(21,6,0,0),
	(21,7,0,0),
	(21,8,0,0),
	(21,9,0,0),
	(21,10,0,0),
	(21,11,0,0),
	
	(22,1,0,0),
	(22,2,0,0),
	(22,3,0,0),
	(22,4,0,0),
	(22,5,0,0),
	(22,6,0,0),
	(22,7,0,0),
	(22,8,0,0),
	(22,9,0,0),
	(22,10,0,0),
	(22,11,0,0),

        (23,1,0,0),
	(23,2,0,0),
	(23,3,0,0),
	(23,4,0,0),
	(23,5,0,0),
	(23,6,0,0),
	(23,7,0,0),
	(23,8,0,0),
	(23,9,0,0),
	(23,10,0,0),
	(23,11,0,0),
	
	(24,1,0,0),
	(24,2,0,0),
	(24,3,0,0),
	(24,4,0,0),
	(24,5,0,0),
	(24,6,0,0),
	(24,7,0,0),
	(24,8,0,0),	
	(24,9,0,0),
	(24,10,0,0),
	(24,11,0,0),
	
	(25,1,0,0),
	(25,2,0,0),
	(25,3,0,0),
	(25,4,0,0),
	(25,5,0,0),
	(25,6,0,0),
	(25,7,0,0),
	(25,8,0,0),
	(25,9,0,0),
	(25,10,0,0),
	(25,11,0,0),
	
	(26,1,0,0),
	(26,2,0,0),
	(26,3,0,0),
	(26,4,0,0),
	(26,5,0,0),
	(26,6,0,0),
	(26,7,0,0),
	(26,8,0,0),
	(26,9,0,0),
	(26,10,0,0),
	(26,11,0,0),
	
	(27,1,0,0),
	(27,2,0,0),
	(27,3,0,0),
	(27,4,0,0),
	(27,5,0,0),
	(27,6,0,0),
	(27,7,0,0),
	(27,8,0,0),
	(27,9,0,0),
	(27,10,0,0),
	(27,11,0,0),
	
	(28,1,0,0),
	(28,2,0,0),
	(28,3,0,0),
	(28,4,0,0),
	(28,5,0,0),
	(28,6,0,0),
	(28,7,0,0),
	(28,8,0,0),
	(28,9,0,0),
	(28,10,0,0),
	(28,11,0,0),
	
	(29,1,0,0),
	(29,2,0,0),
	(29,3,0,0),
	(29,4,0,0),
	(29,5,0,0),
	(29,6,0,0),
	(29,7,0,0),
	(29,8,0,0),
	(29,9,0,0),
	(29,10,0,0),
	(29,11,0,0),
	
	(30,1,0,0),
	(30,2,0,0),
	(30,3,0,0),
	(30,4,0,0),
	(30,5,0,0),
	(30,6,0,0),
	(30,7,0,0),
	(30,8,0,0),
	(30,9,0,0),
	(30,10,0,0),
	(30,11,0,0),
	
	(31,1,0,0),
	(31,2,0,0),
	(31,3,0,0),
	(31,4,0,0),
	(31,5,0,0),
	(31,6,0,0),
	(31,7,0,0),
	(31,8,0,0),
	(31,9,0,0),
	(31,10,0,0),
	(31,11,0,0),
	
	(32,1,0,0),
	(32,2,0,0),
	(32,3,0,0),
	(32,4,0,0),
	(32,5,0,0),
	(32,6,0,0),
	(32,7,0,0),
	(32,8,0,0),
	(32,9,0,0),
	(32,10,0,0),
	(32,11,0,0),
	
	(33,1,0,0),
	(33,2,0,0),
	(33,3,0,0),
	(33,4,0,0),
	(33,5,0,0),
	(33,6,0,0),
	(33,7,0,0),
	(33,8,0,0),
	(33,9,0,0),
	(33,10,0,0),
	(33,11,0,0);

INSERT INTO tournament_result(tournament_id, bracket_id, team_id,result)
VALUES(1,1,13,1),
	(1,1,4,2),
        (1,1,11,3),
	(1,1,5,3),
	
	
	(1,1,15,5),
	(1,1,10,5),
	(1,1,7,5),
	(1,1,1,5),
	
	
	(1,1,16,9),
	(1,1,14,9),
	(1,1,12,9),
	(1,1,9,9),
	(1,1,8,9),
	(1,1,6,9),
	(1,1,3,9),
	(1,1,2,9);

INSERT INTO tournament_team(tournament_id, team_id, seed)
VALUES(1,1,1),
	(1,2,2),
        (1,3,3),
	(1,4,4),
	(1,5,5),
	(1,6,6),
	(1,7,7),
	(1,8,8),
	(1,9,9),
	(1,10,10),
	(1,11,11),
	(1,12,12),
	(1,13,13),
	(1,14,14),
	(1,15,15),
	(1,16,16),

	(2,1,1),
	(2,2,2),
        (2,3,3),
	(2,4,4),
	(2,5,5),
	(2,6,6),
	(2,7,7),
	(2,8,8),
	(2,9,9),
	(2,10,10),
	(2,11,11),
	(2,12,12),
	(2,13,13),
	(2,14,14),
	(2,15,15),
	(2,16,16),

	(3,1,1),
	(3,2,2),
        (3,3,3),
	(3,4,4),
	(3,5,5),
	(3,6,6),
	(3,7,7),
	(3,8,8);
 
 
INSERT INTO tournament_type(description)
VALUES('Single Elimination'),
	('Double Elimination');
	
	
INSERT INTO bracket(tournament_id, tournament_type_id, bracket_name, number_of_rounds)
VALUES(1, 1, 'my single elimination bracket', 4),
	(2,1,'',1),
        (3,1,'',1);
    
    
INSERT INTO bracket_match(tournament_id, bracket_id, team_one_id,team_two_id,round, team_one_wins, team_two_wins, winner_team_id, match_number)
VALUES(1,1,1,2,1   ,2,1    ,1,1),
	(1,1,3,4,1     ,1,2    ,4,2),
        (1,1,5,6,1     ,3,0    ,5,3),
	(1,1,7,8,1     ,2,1    ,7,4),
	(1,1,9,10,1    ,1,2    ,10,5),
	(1,1,11,12,1   ,2,1    ,11,6),
	(1,1,13,14,1   ,3,0    ,13,7),
	(1,1,15,16,1   ,3,0    ,15,8),
	
	(1,1,1,4,2     ,1,2    ,4,9),
	(1,1,5,7,2     ,3,0    ,5,10),
	(1,1,10,11,2   ,1,2    ,11,11),
	(1,1,13,15,2   ,2,1    ,13,12),
	
	(1,1,4,5,3     ,3,0    ,4,13),
	(1,1,11,13,3   ,2,1    ,13,14),
	
	(1,1,13,4,4   ,5,3     ,13,15);
	
INSERT INTO tournament_admin(tournament_id,user_id)
VALUES(1,1),
        (1,2),
        (1,3);

INSERT INTO user_type(description)
VALUES('user'),
        ('admin');


-- create the users and grant priveleges to those users
GRANT SELECT, INSERT, DELETE, UPDATE
ON Splatourney.*
TO mgs_user@localhost
IDENTIFIED BY 'pa55word';
