/*
* Binärwert hat team oder nicht
* NOCH HINZUZUFÜGEN
*
*ALTER TABLE wcf1_user ADD newsNews INT(10) NOT NULL DEFAULT 0;
*/

DROP TABLE IF EXISTS tourneysystem1_teams;
CREATE TABLE tourneysystem1_teams (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
  KEY leaderID (leaderID)
);

ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
