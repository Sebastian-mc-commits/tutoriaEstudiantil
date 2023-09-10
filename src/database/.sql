
CREATE TABLE userTypes (
	id INT AUTO_INCREMENT,
	type VARCHAR(30) NOT NULL,
	PRIMARY KEY(id)
);
INSERT INTO userTypes(type) VALUES ('student'), ('admin'), ('tutor');

CREATE TABLE available_specializations (
	id INT AUTO_INCREMENT,
	name VARCHAR (30) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO available_specializations(name) VALUES ("machine learning"),
("backend end developer"),
("front end developer"),
("database administrator"),
("cybersecurity"),
("ux/ui designer"),
("animator");


CREATE TABLE user (
	id INT AUTO_INCREMENT,
	name VARCHAR(15) NOT NULL,
	email VARCHAR (30) NOT NULL UNIQUE,
	password VARCHAR(16) NOT NULL,
	userType INT DEFAULT 1,
	CONSTRAINT FOREIGN KEY(userType) REFERENCES userTypes(id),
	PRIMARY KEY (id)
);

CREATE TABLE studiesAreas (
	id INT AUTO_INCREMENT,
	area VARCHAR(30) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE studentAreas(
	id INT AUTO_INCREMENT,
	userId INT NOT NULL,
	CONSTRAINT FOREIGN KEY(userId) REFERENCES user(id),
	studyArea INT NOT NULL,
	CONSTRAINT FOREIGN KEY(studyArea) REFERENCES studiesAreas(id),
	PRIMARY KEY(id)
);

INSERT INTO studiesAreas(area) VALUES ('Carrera'), ('Materia');

CREATE TABLE tutorFields (
	id INT AUTO_INCREMENT,
	userId INT DEFAULT 1,
	specialization INT,
	CONSTRAINT FOREIGN KEY(userId) REFERENCES user(id),
	CONSTRAINT FOREIGN KEY(specialization) REFERENCES available_specializations(id) ON DELETE SET NULL,
	PRIMARY KEY (id)
);

-- DELIMITER //;
-- CREATE TRIGGER create_tutor_fields
-- BEFORE INSERT ON tutorFields
-- FOR EACH ROW
-- BEGIN
-- 	DECLARE userType VARCHAR(30);

-- 	SELECT ut.type INTO userType
-- 	FROM user us
-- 	RIGHT JOIN userTypes ut ON us.userType = ut.id
-- 	WHERE us.id = NEW.userId;

-- 	IF userType != 'tutor' THEN
-- 	ROLLBACK;
-- 	END IF;
-- END //;
-- DELIMITER ;

CREATE TABLE mentoring (
	id INT AUTO_INCREMENT,
	mentoringName VARCHAR (30) NOT NULL,
	description VARCHAR (300) NULL,
	tutorCreator INT,
	CONSTRAINT FOREIGN KEY (tutorCreator) REFERENCES tutorFields (id),
	PRIMARY KEY(id)
);

CREATE TABLE schedule (
	id INT AUTO_INCREMENT,
	date DATETIME NOT NULL,
	mentoringId INT,
	CONSTRAINT FOREIGN KEY (mentoringId) REFERENCES mentoring (id) ON DELETE CASCADE,
	endsIn DATE NULL,
	accessLink VARCHAR (300) NOT NULL,
	isAccepted INT(1) DEFAULT 0,
	description VARCHAR (300) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE mentoringRate (
	id INT AUTO_INCREMENT,
	scheduleId INT,
	userId INT,
	mentoringId INT,
	CONSTRAINT FOREIGN KEY (mentoringId) REFERENCES mentoring (id) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (scheduleId) REFERENCES schedule (id) ON DELETE CASCADE,
	CONSTRAINT FOREIGN KEY (userId) REFERENCES user (id),
	comment VARCHAR (300),
	rate INT(5) DEFAULT 1,
	score INT(5),
	PRIMARY KEY (id)
);

CREATE TABLE announcements (
	id INT AUTO_INCREMENT,
	announcementDate DATETIME DEFAULT CURRENT_DATETIME NOT NULL,
	mentoringId INT,
	CONSTRAINT FOREIGN KEY (mentoringId) REFERENCES mentoring (id) ON DELETE CASCADE,
	description VARCHAR (500) NOT NULL,

	PRIMARY KEY (id)
);