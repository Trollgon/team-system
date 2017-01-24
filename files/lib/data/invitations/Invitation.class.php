<?php

namespace teamsystem\data\invitations;

use teamsystem\data\platform\Platform;
use wcf\data\DatabaseObject;
use wcf\system\WCF;
use wcf\system\request\IRouteController;
use teamsystem\data\team\Team;
use teamsystem\data\TEAMSYSTEMDatabaseObject;

class Invitation extends TEAMSYSTEMDatabaseObject implements IRouteController {
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'invitations';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'invitationID';
	
	/**
	 * @see	\wcf\system\request\IRouteController::getTitle()
	 */
	public function getTitle() {
		return NULL;
	}
	
	public function getPositionID() {
		return $this->positionID;
	}
	
	public function getTeamID() {
		return $this->teamID;
	}
	
	public function getTeamTag() {
		$team = new Team($this->teamID);
		return $team->getTeamTag();
	}
	
	public function getTeamName() {
		$team = new Team($this->teamID);
		return $team->getTeamName();
	}
	
	public function getTeamPlatformID() {
		return $this->platformID;
	}
	
	/**
	 * Returns the platform.
	 */
	public function getPlatform() {
		$platform = new Platform($this->getTeamPlatformID());
        return $platform->getPlatformName();
	}
	
	public function getPlayerID() {
		return $this->playerID;
	}
	
	public function getAvatar() {
		$team = new Team($this->teamID);
		return $team->getAvatar();
	}
	
	public function getLeaderID() {
		$team = new Team($this->teamID);
		return $team->leaderID;
	}
	
	/**
	 * Returns the leader from this team
	 * @return    \wcf\data\user\User
	 */
	public function getLeader() {
		return new User($this->getLeaderID());
	}
	
	/**
	 * Returns the user profile from this teams leader.
	 * @return    \wcf\data\user\UserProfile
	 */
	public function getLeaderProfile() {
		return new UserProfile($this->getLeader());
	}
	
}