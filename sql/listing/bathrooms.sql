-- File: bathrooms.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create bathrooms table

DROP TABLE IF EXISTS bathrooms;

CREATE TABLE bathrooms(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE bathrooms OWNER TO group08_admin;

INSERT INTO bathrooms (value, property) VALUES (1, 'One');

INSERT INTO bathrooms (value, property) VALUES (2, 'Two');

INSERT INTO bathrooms (value, property) VALUES (4, 'Three');

INSERT INTO bathrooms (value, property) VALUES (8, 'Four');

INSERT INTO bathrooms (value, property) VALUES (16, 'Five');

INSERT INTO bathrooms (value, property) VALUES (32, 'Six');

INSERT INTO bathrooms (value, property) VALUES (64, 'Seven');