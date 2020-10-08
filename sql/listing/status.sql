-- File: status.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create city property/value table

DROP TABLE IF EXISTS status;

CREATE TABLE status(
value char(1) PRIMARY KEY,
property VARCHAR(15) NOT NULL
);

ALTER TABLE status OWNER TO group08_admin;

INSERT INTO status (value, property) VALUES ('o', 'Open');

INSERT INTO status (value, property) VALUES ('c', 'Closed');

INSERT INTO status (value, property) VALUES ('s', 'Sold');

INSERT INTO status (value, property) VALUES ('h', 'Hidden');