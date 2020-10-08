--Droping table if exists
DROP TABLE IF EXISTS persons;

--Creating the table
CREATE TABLE persons
(
user_id 		VARCHAR(20) REFERENCES users(user_id),
salutation 		VARCHAR(10),
first_name 		VARCHAR(128),
last_name 		VARCHAR(128),
street_address1 	VARCHAR(128),
street_address2 	VARCHAR(128),
city 			VARCHAR(64),
province 		CHAR(2),
postal_code 		CHAR(6),
primary_phone_number 	VARCHAR(15),
secondary_phone_number 	VARCHAR(15),
fax_number 		VARCHAR(15),
preferred_contact_method CHAR(1)
);

--Inserting data into the database tables
INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'jdoe',
		'Mr.',
		'John',
		'Doe',
		'3868 Widdicombe Hill',
		'Whitehorse',
		'YT',
		'Y6J5N1',
		'5366137473',
		'p');

INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'ggoat',
		'Miss',
		'George',
		'Goat',
		'8362 Nanton Avenue',
		'Yellowknife',
		'NS',
		'X6B9L3',
		'3442280332',
		'p');

INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'ccat',
		'Miss',
		'Charlie',
		'Cat',
		'1693 Sirius Crescent',
		'Campbelton',
		'NB',
		'E7N4Y5',
		'2024049852',
		'p');

INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'ddog',
		'Mr.',
		'Dake',
		'Dog',
		'3055 Lane S St Johns W Gilmour',
		'St. Johns',
		'NF',
		'A2K5K3',
		'8862826445',
		'l');

INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'ccow',
		'Mr.',
		'Charles',
		'Cow',
		'4198 Littleleaf Drive',
		'Whitehorse ',
		'YT',
		'Y3K1M6',
		'2748623813',
		'e');

INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, city, province, postal_code, primary_phone_number, preferred_contact_method)  VALUES(
		'dduck',
		'Mr.',
		'Dake',
		'Duck',
		'80 Lane S Dundas E Durie',
		'Iqaluit',
		'NU',
		'X6E6B9',
		'6073425084',
		'e');
