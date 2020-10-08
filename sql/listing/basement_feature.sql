-- File: basement_feature.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create property_type property/value table

DROP TABLE IF EXISTS basement_feature;

CREATE TABLE basement_feature(
value INT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE basement_feature OWNER TO group08_admin;

INSERT INTO basement_feature (value, property) VALUES (1, 'Daylight Basement');

INSERT INTO basement_feature (value, property) VALUES (2, 'Walk-out Basement');

INSERT INTO basement_feature (value, property) VALUES (4, 'Subbasement');

INSERT INTO basement_feature (value, property) VALUES (8, 'Finished fully underground cellar');

INSERT INTO basement_feature (value, property) VALUES (16, 'Underground crawl space');

INSERT INTO basement_feature (value, property) VALUES (32, 'Unfinished Basement');

INSERT INTO basement_feature (value, property) VALUES (64, 'Finished Basement');

INSERT INTO basement_feature (value, property) VALUES (128, 'Partially finished basement');
