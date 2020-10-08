DROP TABLE IF EXISTS favorites;

ALTER TABLE favorites OWNER TO group08_admin;

CREATE TABLE favorites(
user_id VARCHAR(20) NOT NULL,
listing_id INT NOT NULL,
CONSTRAINT FK_UserId FOREIGN KEY (user_id) REFERENCES users(user_id),
CONSTRAINT FK_ListingId FOREIGN KEY (listing_id) REFERENCES listings(listing_id)
);