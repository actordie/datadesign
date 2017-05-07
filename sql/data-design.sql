DROP TABLE IF EXISTS `like`;
DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId    INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail CHAR(64) 							NOT NULL,
	profileHash  CHAR(128)                    NOT NULL,
	profileSalt  CHAR(64)                    NOT NULL,
		UNIQUE (profileEmail),
	PRIMARY KEY (profileId)
);

CREATE TABLE item (
	itemId    INT UNSIGNED AUTO_INCREMENT NOT NULL,
	itemName  CHAR(128)                   NOT NULL,
	itemPrice CHAR(8),
	INDEX (itemId),
	INDEX (itemName),
	UNIQUE (itemId),
	PRIMARY KEY (itemId)
);

CREATE TABLE `like` (
	likeprofileId INT UNSIGNED NOT NULL,
	likeitemId    INT UNSIGNED NOT NULL,
	INDEX (likeprofileId),
	INDEX (likeitemId),
	FOREIGN KEY (likeprofileId) REFERENCES profile (profileId),
	FOREIGN KEY (likeitemId) REFERENCES item (itemId),
	PRIMARY KEY (likeitemId, likeprofileId)
);