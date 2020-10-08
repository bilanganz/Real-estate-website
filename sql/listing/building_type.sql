-- File: building_type.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create property_type property/value table

DROP TABLE IF EXISTS building_type;

CREATE TABLE building_type(
value INT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE building_type OWNER TO group08_admin;

INSERT INTO building_type (value, property) VALUES (1, 'House');

INSERT INTO building_type (value, property) VALUES (2, 'Townhouse / Row');

INSERT INTO building_type (value, property) VALUES (4, 'Apartment');

INSERT INTO building_type (value, property) VALUES (8, 'Duplex');

INSERT INTO building_type (value, property) VALUES (16, 'Triplex');

INSERT INTO building_type (value, property) VALUES (32, 'Garden Home');

INSERT INTO building_type (value, property) VALUES (64, 'Mobile Home');

INSERT INTO building_type (value, property) VALUES (128, 'Manufactured Home/ Mobile');
