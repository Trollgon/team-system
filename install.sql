DROP TABLE IF EXISTS tourneysystem1_teams_pc;
CREATE TABLE tourneysystem1_teams_pc (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player2ID int(10),
  player2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player3ID int(10),
  player3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player4ID int(10),
  player4Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub1ID int(10),
  sub1Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub2ID int(10),
  sub2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub3ID int(10),
  sub3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (leaderName) REFERENCES wcf1_user (username) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (player4Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub1Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_pc ADD FOREIGN KEY (sub3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;

DROP TABLE IF EXISTS tourneysystem1_teams_ps4;
CREATE TABLE tourneysystem1_teams_ps4 (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player2ID int(10),
  player2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player3ID int(10),
  player3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player4ID int(10),
  player4Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub1ID int(10),
  sub1Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub2ID int(10),
  sub2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub3ID int(10),
  sub3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (leaderName) REFERENCES wcf1_user (username) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (player4Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub1Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps4 ADD FOREIGN KEY (sub3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;

DROP TABLE IF EXISTS tourneysystem1_teams_ps3;
CREATE TABLE tourneysystem1_teams_ps3 (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player2ID int(10),
  player2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player3ID int(10),
  player3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player4ID int(10),
  player4Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub1ID int(10),
  sub1Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub2ID int(10),
  sub2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub3ID int(10),
  sub3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (leaderName) REFERENCES wcf1_user (username) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (player4Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub1Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_ps3 ADD FOREIGN KEY (sub3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;

DROP TABLE IF EXISTS tourneysystem1_teams_xb1;
CREATE TABLE tourneysystem1_teams_xb1 (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player2ID int(10),
  player2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player3ID int(10),
  player3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player4ID int(10),
  player4Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub1ID int(10),
  sub1Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub2ID int(10),
  sub2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub3ID int(10),
  sub3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (leaderName) REFERENCES wcf1_user (username) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (player4Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub1Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb1 ADD FOREIGN KEY (sub3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;

DROP TABLE IF EXISTS tourneysystem1_teams_xb360;
CREATE TABLE tourneysystem1_teams_xb360 (
  teamID int(10) NOT NULL AUTO_INCREMENT,
  teamName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  teamTag varchar(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  leaderID int(10),
  leaderName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player2ID int(10),
  player2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player3ID int(10),
  player3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  player4ID int(10),
  player4Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub1ID int(10),
  sub1Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub2ID int(10),
  sub2Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  sub3ID int(10),
  sub3Name varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (teamID),
  UNIQUE KEY teamID (teamID),
);

ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (leaderID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player4ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub1ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub2ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub3ID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (leaderName) REFERENCES wcf1_user (username) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (player4Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub1Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub2Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;
ALTER TABLE tourneysystem1_teams_xb360 ADD FOREIGN KEY (sub3Name) REFERENCES wcf1_user (username) ON DELETE SET NULL;

ALTER TABLE wcf1_user ADD tourneysystemPcTeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD tourneysystemPs4TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD tourneysystemPs3TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD tourneysystemXb1TeamID INT(10) DEFAULT NULL;
ALTER TABLE wcf1_user ADD tourneysystemXb360TeamID INT(10) DEFAULT NULL;

ALTER TABLE wcf1_user ADD FOREIGN KEY (tourneysystemPcTeamID) REFERENCES tourneysystem1_teams_pc (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (tourneysystemPs4TeamID) REFERENCES tourneysystem1_teams_ps4 (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (tourneysystemPs3TeamID) REFERENCES tourneysystem1_teams_ps3 (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (tourneysystemXb1TeamID) REFERENCES tourneysystem1_teams_xb1 (teamID) ON DELETE SET NULL;
ALTER TABLE wcf1_user ADD FOREIGN KEY (tourneysystemXb360TeamID) REFERENCES tourneysystem1_teams_xb360 (teamID) ON DELETE SET NULL;

DROP TABLE IF EXISTS tourneysystem1_invitations;
CREATE TABLE tourneysystem1_invitations (
  invitationID int(10) AUTO_INCREMENT,
  platformID int(10),
  teamID int(10),
  playerID int(10),
  positionID int(10),
  PRIMARY KEY (invitationID),
  UNIQUE KEY invitationID (invitationID),
)

ALTER TABLE tourneysystem1_invitations ADD FOREIGN KEY (playerID) REFERENCES (wcf1_user) ON DELETE CASCADE