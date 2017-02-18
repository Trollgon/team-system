/* Tourneys */

DROP TABLE IF EXISTS tourneysystem1_game;
CREATE TABLE tourneysystem1_game (
  gameID int(10) NOT NULL AUTO_INCREMENT,
  gameName VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (gameID),
  UNIQUE KEY gameID (gameID)
);

DROP TABLE IF EXISTS tourneysystem1_gamemode;
CREATE TABLE tourneysystem1_gamemode (
  gamemodeID int(10) NOT NULL AUTO_INCREMENT,
  gamemodeName VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (gamemodeID),
  UNIQUE KEY gamemodeID (gamemodeID)
);

DROP TABLE IF EXISTS tourneysystem1_platform;
CREATE TABLE tourneysystem1_platform (
  platformID int(10) NOT NULL AUTO_INCREMENT,
  platformName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  optionID int(10) NOT NULL,
  PRIMARY KEY (platformID),
  UNIQUE KEY platformID (platformID)
);

DROP TABLE IF EXISTS tourneysystem1_rulebook;
CREATE TABLE tourneysystem1_rulebook (
  rulebookID int(10) NOT NULL AUTO_INCREMENT,
  rulebookName VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  creatorID int(10) NOT NULL DEFAULT 1,
  officialRulebook BOOLEAN DEFAULT 0,
  PRIMARY KEY (rulebookID),
  UNIQUE KEY rulebookID (rulebookID)
);

DROP TABLE IF EXISTS tourneysystem1_rulebook_article;
CREATE TABLE tourneysystem1_rulebook_article (
  rulebookArticleID int(10) NOT NULL AUTO_INCREMENT,
  articleOrder int(10) NOT NULL,
  rulebookArticleName VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  rulebookID int(10) NOT NULL,
  PRIMARY KEY (rulebookArticleID),
  UNIQUE KEY rulebookArticleID (rulebookArticleID)
);

DROP TABLE IF EXISTS tourneysystem1_rulebook_rule;
CREATE TABLE tourneysystem1_rulebook_rule (
  ruleID int(10) NOT NULL AUTO_INCREMENT,
  ruleOrder int(10) NOT NULL,
  text MEDIUMTEXT COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  articleID int(10) NOT NULL,
  PRIMARY KEY (ruleID),
  UNIQUE KEY ruleID (ruleID)
);

DROP TABLE IF EXISTS tourneysystem1_tourney;
CREATE TABLE tourneysystem1_tourney (
  tourneyID int(10) NOT NULL AUTO_INCREMENT,
  platformID int(10) NOT NULL,
  gameID int(10) NOT NULL,
  gamemodeID int(10) NOT NULL,
  tourneyName varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  participantType INT(10),
  avatarID INT(10),
  rulebookID INT(10),
  tourneyDescription MEDIUMTEXT,
  firstTourneyMode INT(10) NOT NULL,
  tourneyStartTime INT(10),
  tourneyStatus INT(10),
  minParticipants INT(10),
  maxParticipants INT(10),
  creatorID INT(10),
  officialTourney BOOLEAN DEFAULT 0,
  PRIMARY KEY (tourneyID),
  UNIQUE KEY tourneyID (tourneyID)
);

DROP TABLE IF EXISTS tourneysystem1_referee_to_tourney;
CREATE TABLE tourneysystem1_referee_to_tourney (
  userID int(10) NOT NULL,
  tourneyID int(10) NOT NULL
);

CREATE TABLE tourneysystem1_sign_up (
  tourneyID int(10) NOT NULL,
  participantID    INT(10) NOT NULL
);

DROP TABLE tourneysystem1_match_day;
CREATE TABLE tourneysystem1_match_day (
  matchDayID INT(10) NOT NULL AUTO_INCREMENT,
  tourneyID int(10) NOT NULL,
  startDate DATETIME,
  endDate DATETIME,
  PRIMARY KEY (matchDayID),
  UNIQUE KEY matchDayID (matchDayID)
);

DROP TABLE IF EXISTS tourneysystem1_match;
CREATE TABLE tourneysystem1_match (
  matchID int(10) NOT NULL AUTO_INCREMENT,
  tourneyID int(10) NOT NULL,
  matchDayID int(10),
  participantTypeID int(10) NOT NULL,
  numberOfMaxSessions int(10) NOT NULL DEFAULT 1,
  PRIMARY KEY (matchID),
  UNIQUE KEY matchID (matchID)
);

DROP TABLE IF EXISTS tourneysystem1_participant_to_match;
CREATE TABLE tourneysystem1_participant_to_match (
  matchID int(10) NOT NULL,
  participantID int(10) NOT NULL
);

/* Teams */

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

/* Foreign Keys */

ALTER TABLE tourneysystem1_platform ADD FOREIGN KEY (optionID) REFERENCES wcf1_user_option (optionID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_rulebook ADD FOREIGN KEY (creatorID) REFERENCES wcf1_user (userID) ON DELETE SET DEFAULT;

ALTER TABLE tourneysystem1_rulebook_article ADD FOREIGN KEY (rulebookID) REFERENCES tourneysystem1_rulebook (rulebookID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_rulebook_rule ADD FOREIGN KEY (articleID) REFERENCES tourneysystem1_rulebook_article (rulebookArticleID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_tourney ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_tourney ADD FOREIGN KEY (gameID) REFERENCES tourneysystem1_game (gameID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_tourney ADD FOREIGN KEY (gamemodeID) REFERENCES tourneysystem1_gamemode (gamemodeID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_tourney ADD FOREIGN KEY (rulebookID) REFERENCES tourneysystem1_rulebook (rulebookID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_tourney ADD FOREIGN KEY (creatorID) REFERENCES wcf1_user (userID) ON DELETE SET NULL;

ALTER TABLE tourneysystem1_match_day ADD FOREIGN KEY (tourneyID) REFERENCES tourneysystem1_tourney (tourneyID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_match ADD FOREIGN KEY (tourneyID) REFERENCES tourneysystem1_tourney (tourneyID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_match ADD FOREIGN KEY (matchDayID) REFERENCES tourneysystem1_match_day (matchDayID) ON DELETE CASCADE;

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

ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_user_to_team_to_position_to_platform ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (platformID) REFERENCES tourneysystem1_platform (platformID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;
ALTER TABLE tourneysystem1_invitation ADD FOREIGN KEY (playerID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;

ALTER TABLE tourneysystem1_team_avatar ADD FOREIGN KEY (teamID) REFERENCES tourneysystem1_team (teamID) ON DELETE CASCADE;