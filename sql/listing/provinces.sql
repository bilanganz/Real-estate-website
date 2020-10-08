-- File: provinces.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create provinces table

DROP TABLE IF EXISTS provinces;

CREATE TABLE provinces(
	value CHAR(2)
);

ALTER TABLE provinces OWNER TO group08_admin;

INSERT INTO provinces VALUES ('AB');
INSERT INTO provinces VALUES ('BC');
INSERT INTO provinces VALUES ('MB');
INSERT INTO provinces VALUES ('NB');
INSERT INTO provinces VALUES ('NF');
INSERT INTO provinces VALUES ('NS');
INSERT INTO provinces VALUES ('NT');
INSERT INTO provinces VALUES ('NU');
INSERT INTO provinces VALUES ('ON');
INSERT INTO provinces VALUES ('PE');
INSERT INTO provinces VALUES ('PQ');
INSERT INTO provinces VALUES ('SK');
INSERT INTO provinces VALUES ('YT');