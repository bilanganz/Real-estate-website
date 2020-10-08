-- File: preferred_contact_methods.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create preferred_contact_methods table

DROP TABLE IF EXISTS preferred_contact_methods;

CREATE TABLE preferred_contact_methods(
value VARCHAR(1) PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE preferred_contact_methods OWNER TO group08_admin;

INSERT INTO preferred_contact_methods (value, property) VALUES ('e', 'E-mail');

INSERT INTO preferred_contact_methods (value, property) VALUES ('p', 'Phone Call');

INSERT INTO preferred_contact_methods (value, property) VALUES ('l', 'Letter Post');
