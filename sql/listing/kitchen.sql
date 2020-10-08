-- File: kitchen.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create parking_lot table

DROP TABLE IF EXISTS kitchen ;

CREATE TABLE kitchen(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE kitchen OWNER TO group08_admin;

INSERT INTO kitchen (value, property) VALUES (1, 'One');

INSERT INTO kitchen (value, property) VALUES (2, 'Two');

INSERT INTO kitchen (value, property) VALUES (4, 'Three');
