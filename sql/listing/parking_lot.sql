-- File: parking_lot.sql
-- Author: Group08
-- Date: 10.23.2019
-- Description: SQL file to create parking_lot table

DROP TABLE IF EXISTS parking_lot ;

CREATE TABLE parking_lot(
value SMALLINT PRIMARY KEY,
property VARCHAR(30) NOT NULL
);

ALTER TABLE parking_lot OWNER TO group08_admin;

INSERT INTO parking_lot (value, property) VALUES (1, 'One');

INSERT INTO parking_lot (value, property) VALUES (2, 'Two');

INSERT INTO parking_lot (value, property) VALUES (4, 'Three');

INSERT INTO parking_lot (value, property) VALUES (8, 'Four');

INSERT INTO parking_lot (value, property) VALUES (16, 'Five');

INSERT INTO parking_lot (value, property) VALUES (32, 'Six');

INSERT INTO parking_lot (value, property) VALUES (64, 'Seven');

INSERT INTO parking_lot (value, property) VALUES (128, 'Eight');

INSERT INTO parking_lot (value, property) VALUES (256, 'Nine');

INSERT INTO parking_lot (value, property) VALUES (512, 'Ten');