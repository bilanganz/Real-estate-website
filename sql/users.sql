--Droping table if exists
DROP TABLE IF EXISTS users;

--Creating the table
CREATE TABLE users
(
user_id VARCHAR(20) 		PRIMARY KEY,
password VARCHAR(32) 		NOT NULL,
user_type VARCHAR(2) 		NOT NULL,
email_address VARCHAR(256) 	NOT NULL,
enrol_date DATE 		NOT NULL,
last_access DATE 		NOT NULL
);

--Inserting data into the database tables
INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'jdoe',
		md5('testpass'),
		's',
		'jdoe@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'dduck',
		md5('password1'),
		'a',
		'dduck@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'ggoat',
		md5('password2'),
		'c',
		'ggoat@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'ccat',
		md5('password3'),
		'p',
		'ccat@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'ddog',
		md5('password4'),
		'dc',
		'ddog@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

INSERT INTO users(user_id, password, user_type, email_address, enrol_date, last_access)  VALUES(
		'ccow',
		md5('password5'),
		'ia',
		'ccow@durhamcollege.ca',
		'2019-09-24',
		'2019-09-24');

