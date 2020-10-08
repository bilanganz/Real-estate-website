-- File: land_size.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create parking_lot table

DROP TABLE IF EXISTS land_size ;

CREATE TABLE land_size(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE land_size OWNER TO group08_admin;

INSERT INTO land_size (value, property) VALUES (1, '1+ Acres');

INSERT INTO land_size (value, property) VALUES (2, '5+ Acres');

INSERT INTO land_size (value, property) VALUES (4, '10+ Acres');

INSERT INTO land_size (value, property) VALUES (8, '50+ Acres');

INSERT INTO land_size (value, property) VALUES (16, '100+ Acres');

INSERT INTO land_size (value, property) VALUES (32, '250+ Acres');

INSERT INTO land_size (value, property) VALUES (64, '500+ Acres');
