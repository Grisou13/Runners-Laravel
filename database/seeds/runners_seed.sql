SET NAMES 'utf8';
-- Runners
INSERT INTO groups (color, name, active) VALUES ('ff9933','A',1),('ffff00','B',1),('ff0000','C',1),('00ffff','D',1),('a6a6a6','E',1),('00ff00','F',1),('ff99ff','G',1),('0033cc','H',1);
-- Coordinators
INSERT INTO groups (color, name, active) VALUES ('dd0806','C1',1),('1fb714','C2',1),('3366ff','C3',1),('f20884','C4',1),('fcf305','C5',1);

-- Runners
INSERT INTO schedule_groups (group_id,start_time,end_time) values
(5,'2017-07-17 11:00','2017-07-18 02:00'),
(3,'2017-07-17 10:00','2017-07-17 15:00'),
(4,'2017-07-17 10:00','2017-07-17 15:00'),
(7,'2017-07-17 10:00','2017-07-17 15:00'),
(8,'2017-07-17 10:00','2017-07-17 15:00'),

(1,'2017-07-18 07:30','2017-07-18 14:30'),
(2,'2017-07-19 07:30','2017-07-19 14:30'),
(3,'2017-07-20 07:30','2017-07-20 14:30'),
(4,'2017-07-21 07:30','2017-07-21 14:30'),
(5,'2017-07-22 07:30','2017-07-22 14:30'),
(6,'2017-07-23 07:30','2017-07-23 14:30'),
(7,'2017-07-24 07:30','2017-07-24 14:30'),

(2,'2017-07-18 10:00','2017-07-18 17:00'),
(3,'2017-07-19 10:00','2017-07-19 17:00'),
(4,'2017-07-20 10:00','2017-07-20 17:00'),
(5,'2017-07-21 10:00','2017-07-21 17:00'),
(6,'2017-07-22 10:00','2017-07-22 17:00'),
(7,'2017-07-23 10:00','2017-07-23 17:00'),
(8,'2017-07-24 10:00','2017-07-24 17:00'),

(3,'2017-07-18 13:00','2017-07-18 20:00'),
(4,'2017-07-19 13:00','2017-07-19 20:00'),
(5,'2017-07-20 13:00','2017-07-20 20:00'),
(6,'2017-07-21 13:00','2017-07-21 20:00'),
(7,'2017-07-22 13:00','2017-07-22 20:00'),
(8,'2017-07-23 13:00','2017-07-23 20:00'),

(4,'2017-07-18 14:30','2017-07-18 22:00'),
(5,'2017-07-19 14:30','2017-07-19 22:00'),
(6,'2017-07-20 14:30','2017-07-20 22:00'),
(7,'2017-07-21 14:30','2017-07-21 22:00'),
(8,'2017-07-22 14:30','2017-07-22 22:00'),
(1,'2017-07-23 14:30','2017-07-23 22:00'),

(5,'2017-07-18 18:00','2017-07-19 00:00'),
(6,'2017-07-19 18:00','2017-07-20 00:00'),
(7,'2017-07-20 18:00','2017-07-21 00:00'),
(8,'2017-07-21 18:00','2017-07-22 00:00'),
(1,'2017-07-22 18:00','2017-07-23 00:00'),
(2,'2017-07-23 18:00','2017-07-24 00:00'),

(6,'2017-07-18 22:00','2017-07-19 03:00'),
(7,'2017-07-19 22:00','2017-07-20 03:00'),
(8,'2017-07-20 22:00','2017-07-21 03:00'),
(1,'2017-07-21 22:00','2017-07-22 03:00'),
(2,'2017-07-22 22:00','2017-07-23 03:00'),
(3,'2017-07-23 22:00','2017-07-24 03:00'),

(7,'2017-07-18 23:00','2017-07-19 04:00'),
(8,'2017-07-19 23:00','2017-07-20 04:00'),
(1,'2017-07-20 23:00','2017-07-21 04:00'),
(2,'2017-07-21 23:00','2017-07-22 04:00'),
(3,'2017-07-22 23:00','2017-07-23 04:00'),
(4,'2017-07-23 23:00','2017-07-24 04:00'),

(8,'2017-07-19 01:00','2017-07-19 08:00'),
(1,'2017-07-20 01:00','2017-07-20 08:00'),
(2,'2017-07-21 01:00','2017-07-21 08:00'),
(3,'2017-07-22 01:00','2017-07-22 08:00'),
(4,'2017-07-23 01:00','2017-07-23 08:00'),
(5,'2017-07-24 01:00','2017-07-24 08:00'),

(8,'2017-07-24 10:00','2017-07-24 17:00'),
(1,'2017-07-24 10:00','2017-07-24 14:30'),
(2,'2017-07-24 10:00','2017-07-24 14:30'),
(6,'2017-07-24 10:00','2017-07-24 14:30');

-- Coordinators
INSERT INTO schedule_groups (group_id,start_time,end_time) values
(9,'2017-07-17 11:00','2017-07-17 18:00'),
(10,'2017-07-17 11:00','2017-07-17 18:00'),
(11,'2017-07-17 11:00','2017-07-17 18:00'),
(12,'2017-07-17 11:00','2017-07-17 18:00'),
(13,'2017-07-17 11:00','2017-07-17 18:00'),

(9,'2017-07-18 08:00','2017-07-17 14:00'),
(10,'2017-07-19 08:00','2017-07-17 14:00'),
(11,'2017-07-20 08:00','2017-07-17 14:00'),
(12,'2017-07-21 08:00','2017-07-17 14:00'),
(13,'2017-07-22 08:00','2017-07-17 14:00'),
(9,'2017-07-23 08:00','2017-07-17 14:00'),

(10,'2017-07-18 14:00','2017-07-18 20:00'),
(11,'2017-07-19 14:00','2017-07-19 20:00'),
(12,'2017-07-20 14:00','2017-07-20 20:00'),
(13,'2017-07-21 14:00','2017-07-21 20:00'),
(9,'2017-07-22 14:00','2017-07-22 20:00'),
(10,'2017-07-23 14:00','2017-07-23 20:00'),

(11,'2017-07-18 20:00','2017-07-18 23:00'),
(12,'2017-07-19 20:00','2017-07-19 23:00'),
(13,'2017-07-20 20:00','2017-07-20 23:00'),
(9,'2017-07-21 20:00','2017-07-21 23:00'),
(10,'2017-07-22 20:00','2017-07-22 23:00'),
(12,'2017-07-23 20:00','2017-07-23 23:00'),

(12,'2017-07-18 23:00','2017-07-19 02:00'),
(13,'2017-07-19 23:00','2017-07-20 02:00'),
(9,'2017-07-20 23:00','2017-07-21 02:00'),
(10,'2017-07-21 23:00','2017-07-22 02:00'),
(11,'2017-07-22 23:00','2017-07-23 02:00'),
(12,'2017-07-23 23:00','2017-07-24 02:00'),

(13,'2017-07-19 02:00','2017-07-19 08:00'),
(9,'2017-07-20 02:00','2017-07-20 08:00'),
(10,'2017-07-21 02:00','2017-07-21 08:00'),
(11,'2017-07-22 02:00','2017-07-22 08:00'),
(12,'2017-07-23 02:00','2017-07-23 08:00'),
(13,'2017-07-24 02:00','2017-07-24 08:00'),

(9,'2017-07-24 10:00','2017-07-24 15:00'),
(10,'2017-07-24 11:00','2017-07-24 16:00'),
(11,'2017-07-24 12:00','2017-07-24 17:00');

DELIMITER $$
-- XCL, 1.6.2107
-- A procedure that splits big schedule blocks into 30 minutes consecutive blocks
CREATE PROCEDURE split()
BEGIN
	DECLARE gid INT;
	DECLARE startt DATETIME;
	DECLARE endt DATETIME;
	DECLARE finished INT DEFAULT 0;
	DEClARE blocks CURSOR FOR SELECT group_id, start_time, end_time FROM schedule_groups WHERE TIMESTAMPDIFF(MINUTE,start_time,end_time) > 30 ORDER BY start_time,group_id;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
	OPEN blocks;
	get_block: LOOP
		FETCH blocks INTO gid, startt, endt;
		IF finished = 1 THEN
			LEAVE get_block;
		END IF;
		WHILE TIMESTAMPDIFF(MINUTE,startt, endt) >= 30 DO
			INSERT INTO schedule_groups(group_id, start_time, end_time) VALUES (gid, startt, ADDTIME(startt,'00:30:00'));
			SET startt = ADDTIME(startt,'00:30:00') ;
		END WHILE;
	END LOOP get_block;
	CLOSE blocks;
	DELETE FROM schedule_groups WHERE TIMESTAMPDIFF(MINUTE,start_time,end_time) > 30;
END;
$$
CALL split();
DROP PROCEDURE split;

DROP INDEX users_email_unique ON users;

-- Runners
INSERT INTO users (lastname,firstname,phone_number,sex, accesstoken, password, email, group_id) VALUES
('Angiolili','Aude','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',1),
('Delacrétaz','Nicolas','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',1),
('Fritsché','Yves','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',1),
('Ganz','Mélanie','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',1),
('Martin','Patrick','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',1),

('Beck','Matthieu','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',2),
('Lager','Michel','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',2),
('Miesegaes','Nicolas','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',2),
('Pinilla','Christian','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',2),
('Pinilla-Marin','Andres','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',2),

('Bourgeois','Carole','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),
('Courdier','Marc','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),
('Fleischmann','Julien','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),
('Gagliardo','Serge','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),
('Howells','Kevin','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),
('Rosso','Marc','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',3),

('Gauthier','Océane','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',4),
('Janin-Cancian','Léonore','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',4),
('Janin','Héloïse','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',4),
('Lopez','Vincent','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',4),
('Rais','Sébastien','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',4),

('Colin','Jacques','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',5),
('Ducry','Jean-Marc','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',5),
('Harb','David','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',5),
('Schindler','René','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',5),
('Ujvari','Laura','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',5),

('Baillif','Robin','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),
('Berger','Sandra','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),
('Bernasconi','Pierre-Yves','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),
('Bobillier','Vincent','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),
('German','Eladio','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),
('Wolf','Julien','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',6),

('Anderes','Jean-Marc','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),
('Baechler','Oliver','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),
('Chiabudini','Enrico','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),
('Comminot','Pascal','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),
('Gojun','Matia','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),
('Ramos','Joao','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',7),

('Féry-Hammer','Christine','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',8),
('Korkia','David','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',8),
('Perret','Valérie','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',8),
('Pouilly','Bertrand','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',8),
('Schumacher','Paul','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',8);


-- Coordinators
INSERT INTO users (firstname,lastname,phone_number,sex, accesstoken, password, email, group_id) VALUES
('Roland','Fleischman','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',9),
('Julien','Borel','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',9),
('Nicole','Gautier','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',10),
('Laurent','Jung','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',10),
('Daniel','Grosjean','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',11),
('Floriane','Piguet','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',11),
('Simone','Muller','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',12),
('Laurent','Mingard','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',12),
('Gérald','Chaignat','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',13),
('Xavier','Carrel','(474) 962-4639',0,CAST(1000+floor(1000000*rand()) AS CHAR(100)),'password','email',13);


UPDATE users SET email=CONCAT(firstname,'.',lastname,'@paleo.ch');

CREATE UNIQUE INDEX users_email_unique ON users(email);
