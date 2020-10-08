-- File: living_room.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create parking_lot table

DROP TABLE IF EXISTS living_room ;

CREATE TABLE living_room(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE living_room OWNER TO group08_admin;

INSERT INTO living_room (value, property) VALUES (1, 'One');

INSERT INTO living_room (value, property) VALUES (2, 'Two');

INSERT INTO living_room (value, property) VALUES (4, 'Three');
