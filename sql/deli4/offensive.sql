DROP TABLE IF EXISTS offensives;

ALTER TABLE offensives OWNER TO group08_admin;

CREATE TABLE offensives(
user_id VARCHAR(20) NOT NULL,
listing_id INT NOT NULL,
reported_on DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
status CHAR(1) NOT NULL,
PRIMARY KEY(user_id, listing_id),
CONSTRAINT FK_UserId FOREIGN KEY (user_id) REFERENCES users(user_id),
CONSTRAINT FK_ListingId FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
);