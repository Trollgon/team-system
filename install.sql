/*
* Eine Spalte pro konsole (standard NULL)
* NOCH HINZUZUFÜGEN
*
*ALTER TABLE wcf1_user ADD newsNews INT(10) DEFAULT NULL;
*/

DROP TABLE IF EXISTS tourneysystem1_teams;
CREATE TABLE tourneysystem1_teams (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  player2ID int(10),
  player3ID int(10),
  player4ID int(10),
  sub1ID int(10),
  sub2ID int(10),
  sub3ID int(10),
  platform varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
