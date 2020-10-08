DROP TABLE IF EXISTS listings;

ALTER TABLE listings OWNER TO group08_admin;
CREATE TABLE listings(
	listing_id SERIAL PRIMARY KEY,
	user_id VARCHAR(20),
	headline VARCHAR(100) NOT NULL,
	price NUMERIC NOT NULL,
	status CHAR(1)  NOT NULL,
	description VARCHAR(1000) NOT NULL,
	property_type INT NOT NULL DEFAULT 0,
	property_options INT NOT NULL,
	transaction_type INT NOT NULL DEFAULT 0,
	building_type INT NOT NULL DEFAULT 0,
	heating_type INT NOT NULL DEFAULT 0,
	bedrooms INT NOT NULL,
	bathrooms INT NOT NULL,	
	living_room INT NOT NULL DEFAULT 0,
	kitchen INT NOT NULL DEFAULT 0,
	basement_feature INT NOT NULL DEFAULT 0,
	parking_lot INT NOT NULL DEFAULT 0,
	building_size INT NOT NULL DEFAULT 0,
	land_size INT NOT NULL DEFAULT 0,
	address VARCHAR(200) NOT NULL,
	city INT NOT NULL,
	postal_code CHAR(6) NOT NULL,
	image SMALLINT NOT NULL DEFAULT 0,
	CONSTRAINT FK_UserListing FOREIGN KEY (user_id) REFERENCES users(user_id)
);