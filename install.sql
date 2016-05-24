DROP TABLE IF EXISTS teamsystem1_teams;
CREATE TABLE teamsystem1_teams (
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
  teamDescription MEDIUMTEXT,
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (contactID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;

ALTER TABLE wcf1_user ADD teamsystemPcTeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemPcTeamPositionID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemPs4TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemPs4TeamPositionID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemPs3TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemPs3TeamPositionID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemXb1TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemXb1TeamPositionID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemXb360TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD teamsystemXb360TeamPositionID INT(10) DEFAULT NULL;

ALTER TABLE wcf1_user ADD FOREIGN KEY (teamsystemPcTeamID) REFERENCES teamsystem1_teams (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (teamsystemPs4TeamID) REFERENCES teamsystem1_teams (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (teamsystemPs3TeamID) REFERENCES teamsystem1_teams (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (teamsystemXb1TeamID) REFERENCES teamsystem1_teams (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (teamsystemXb360TeamID) REFERENCES teamsystem1_teams (teamID) ON DELETE SET NULL;

DROP TABLE IF EXISTS teamsystem1_invitations;
CREATE TABLE teamsystem1_invitations (
  invitationID int(10) AUTO_INCREMENT,
  platformID int(10),
  teamID int(10),
  playerID int(10),
  positionID int(10),
  PRIMARY KEY (invitationID),
  UNIQUE KEY invitationID (invitationID),
)

ALTER TABLE teamsystem1_invitations ADD FOREIGN KEY (playerID) REFERENCES (wcf1_user) ON DELETE CASCADE

DROP TABLE IF EXISTS teamsystem1_team_avatar;
CREATE TABLE teamsystem1_team_avatar (
	avatarID INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	avatarName VARCHAR(255) NOT NULL DEFAULT '',
	avatarExtension VARCHAR(7) NOT NULL DEFAULT '',
	width SMALLINT(5) NOT NULL DEFAULT 0,
	height SMALLINT(5) NOT NULL DEFAULT 0,
	teamID INT(10),
	fileHash VARCHAR(40) NOT NULL DEFAULT '',
	cropX SMALLINT(5) NOT NULL DEFAULT 0,
	cropY SMALLINT(5) NOT NULL DEFAULT 0
)

ALTER TABLE teamsystem1_team_avatar ADD FOREIGN KEY (teamID) REFERENCES teamsystem1_teams (teamID) ON DELETE CASCADE;
ALTER TABLE teamsystem1_teams ADD FOREIGN KEY (avatarID) REFERENCES teamsystem1_team_avatar (avatarID) ON DELETE SET NULL;