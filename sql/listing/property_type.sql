-- File: property_type.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create property_type property/value table

DROP TABLE IF EXISTS property_type;

CREATE TABLE property_type(
value INT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE property_type OWNER TO group08_admin;

INSERT INTO property_type (value, property) VALUES (1, 'Residential');

INSERT INTO property_type (value, property) VALUES (2, 'Recreational');

INSERT INTO property_type (value, property) VALUES (4, 'Condo/Strata');

INSERT INTO property_type (value, property) VALUES (8, 'Multi Family');

INSERT INTO property_type (value, property) VALUES (16, 'Agriculture');

INSERT INTO property_type (value, property) VALUES (32, 'Parking');

INSERT INTO property_type (value, property) VALUES (64, 'Vacant Land');

