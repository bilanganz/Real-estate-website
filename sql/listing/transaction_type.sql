-- File: transaction_type.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create property_type property/value table

DROP TABLE IF EXISTS transaction_type;

CREATE TABLE transaction_type(
value INT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE transaction_type OWNER TO group08_admin;

INSERT INTO transaction_type (value, property) VALUES (1, 'For Sale');

INSERT INTO transaction_type (value, property) VALUES (2, 'For Rent');

