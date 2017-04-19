DROP TABLE IF EXISTS 'like';
DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId    INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileEmail VARCHAR(128)                NOT NULL,
	profileHash  CHAR(64)                   NOT NULL,
	profileSalt  CHAR(64)
	UNIQUE(profileEmail),
	PRIMARY KEY(profileId)
	);

	CREATE TABLE item (
		itemId      INT UNSIGNED AUTO_INCREMENT NOT NULL,
		itemImgpath INT UNSIGNED,
		itemName    CHAR(128)                   NOT NULL,
		itemInfo    VARCHAR(140),
		INDEX (itemId),
		INDEX (NAME),
		UNIQUE (itemId),
		PRIMARY KEY (itemId)
	);

CREATE TABLE 'like' (
	likeprofileId INT UNSIGNED NOT NULL,
	likeId        INT UNSIGNED NOT NULL,
	likeitemId    INT UNSIGNED NOT NULL,
	INDEX(likeprofileId),
	INDEX(likeitemId),
	FOREIGN KEY (likeprofileId) REFERENCES profile (profileId),
	FOREIGN KEY (likeitemId) REFERENCES item (itemId),
	PRIMARY KEY (likeitemId, likeprofileId)
	);