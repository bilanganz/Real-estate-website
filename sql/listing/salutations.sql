-- File: salutations.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create salutations table

DROP TABLE IF EXISTS salutations;

CREATE TABLE salutations(
	value VARCHAR(5)
);

ALTER TABLE salutations OWNER TO group08_admin;

INSERT INTO salutations VALUES ('Mr.');

INSERT INTO salutations VALUES ('Mrs.');

INSERT INTO salutations VALUES ('Miss');

INSERT INTO salutations VALUES ('Ms.');