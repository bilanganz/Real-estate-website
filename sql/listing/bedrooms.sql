-- File: bedrooms.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create bedrooms table

DROP TABLE IF EXISTS bedrooms;

CREATE TABLE bedrooms(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE bedrooms OWNER TO group08_admin;

INSERT INTO bedrooms (value, property) VALUES (1, 'One');

INSERT INTO bedrooms (value, property) VALUES (2, 'Two');

INSERT INTO bedrooms (value, property) VALUES (4, 'Three');

INSERT INTO bedrooms (value, property) VALUES (8, 'Four');

INSERT INTO bedrooms (value, property) VALUES (16, 'Five');

INSERT INTO bedrooms (value, property) VALUES (32, 'Six');

INSERT INTO bedrooms (value, property) VALUES (64, 'Seven');