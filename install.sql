DROP TABLE IF EXISTS tourneysystem1_team;
CREATE TABLE tourneysystem1_team (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  platformID int(10) NOT NULL,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  avatarID INT(10),
  leaderID int(10) NOT NULL,
  player2ID int(10),
  player3ID int(10),
  player4ID int(10),
  sub1ID int(10),
  sub2ID int(10),
  sub3ID int(10),
  contactID int(10),
  registrationDate int(10),
  teamDescription MEDIUMTEXT,
  dummyTeam BOOLEAN DEFAULT 0,
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID)
);

DROP TABLE IF EXISTS tourneysystem1_platform;
CREATE TABLE tourneysystem1_platform (
  platformID int(10) NOT NULL AUTO_INCREMENT,
  platformName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  optionID int(10) NOT NULL,
  PRIMARY KEY (platformID),
  UNIQUE KEY platformID (platformID),
);

DROP TABLE IF EXISTS tourneysystem1_user_to_team_to_position_to_platform;
CREATE TABLE tourneysystem1_user_to_team_to_position_to_platform (
  userID INT(10) NOT NULL,
  teamID INT(10) NOT NULL,
  platformID INT(10) NOT NULL,
  positionID INT(10) NOT NULL
);

DROP TABLE IF EXISTS tourneysystem1_invitation;
CREATE TABLE tourneysystem1_invitation (
  invitationID int(10) AUTO_INCREMENT,
  platformID int(10) NOT NULL,
  teamID int(10) NOT NULL,
  playerID int(10) NOT NULL,
  positionID int(10) NOT NULL,
  PRIMARY KEY (invitationID),
  UNIQUE KEY invitationID (invitationID)
);

DROP TABLE IF EXISTS tourneysystem1_team_avatar;
CREATE TABLE tourneysystem1_team_avatar (
  avatarID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  avatarName VARCHAR(255) NOT NULL DEFAULT '',
  avatarExtension VARCHAR(7) NOT NULL DEFAULT '',
  width SMALLINT(5) NOT NULL DEFAULT 0,
  height SMALLINT(5) NOT NULL DEFAULT 0,
  teamID INT(10),
  fileHash VARCHAR(40) NOT NULL DEFAULT '',
  cropX SMALLINT(5) NOT NULL DEFAULT 0,
  cropY SMALLINT(5) NOT NULL DEFAULT 0
);

ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (contactID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_team ADD FOREIGN KEY (avatarID) REFERENCES tourneysystem1_team_avatar (avatarID) ON DELETE SET NULL;

ALTER TABLE tourneysystem1_platform ADD FOREIGN KEY (optionID) REFERENCES wcf1_user_option (optionID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (playerID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_team_avatar ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;