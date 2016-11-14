<?php

namespace teamsystem\data\team;

use wcf\data\DatabaseObject;
use wcf\system\user\storage\UserStorageHandler;
use wcf\system\WCF;
use wcf\system\request\IRouteController;
use wcf\data\user\User;
use teamsystem\data\TEAMSYSTEMDatabaseObject;
use teamsystem\data\team\avatar\DefaultTeamAvatar;
use teamsystem\data\team\avatar\TeamAvatar;
use wcf\data\user\UserProfile;

class Team extends TEAMSYSTEMDatabaseObject implements IRouteController{
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'teams';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'teamID';
	
	/**
	* team avatar
	* @var	\wcf\data\user\avatar\IUserAvatar
	*/
	protected $avatar = null;
	
	/**
	 * leader profile object
	 * @var	\wcf\data\user\UserProfile
	 */
	protected $leaderProfile = null;
	
	/**
	 * @see	\wcf\system\request\IRouteController::getTitle()
	 */
	public function getTitle() {
		return $this->teamName;
	}
	
	/**
	 * Returns the Team ID.
	 */
	public function getTeamID() {
		return $this->teamID;
	}
	
	/**
	 * Returns the Team name.
	 */
	public function getTeamName() {
		return $this->teamName;
	}
	
	/**
	 * Returns the Team tag.
	 */
	public function getTeamTag() {
		return $this->teamTag;
	}
	
	/**
	 * Returns the team's PlatformID.
	 */
	public function getPlatformID() {
		return $this->platformID;
	}
	
	/**
	 * Returns the platform.
	 */
	public function getPlatform() {
		switch ($this->platformID) {
			case 1:
				return "PC";
				break;
			case 2:
				return "PlayStation 4";
				break;
			case 3:
				return "PlayStation 3";
				break;
			case 4:
				return "Xbox One";
				break;
			case 5:
				return "Xbox 360";
				break;
		}
	}
	
	/**
	 * Returns true if the player is the team leader.
	 */
	public function isTeamLeader() {
		return WCF::getUser()->userID == $this->leaderID;
	}
	
	/**
	 * Returns true if the player is a team member.
	 */
	public function isTeamMember() {
		return (WCF::getUser()->getUserID() == $this->player2ID || WCF::getUser()->getUserID() == $this->player3ID || WCF::getUser()->getUserID() == $this->player4ID || WCF::getUser()->getUserID() == $this->sub1ID ||  WCF::getUser()->getUserID() == $this->sub2ID || WCF::getUser()->getUserID() == $this->sub3ID);
	}
	
	/**
	 * Returns the positionID of the given player.
	 */
	public function getPositionID($playerID, $platformID, $teamID) {
		$user = new User($playerID);
	
		switch ($platformID) {
			case 1:
				if ($user->teamsystemPcTeamID == $teamID) {
					return $user->teamsystemPcTeamPositionID;
				}
				break;
			case 2:
				if ($user->teamsystemPs4TeamID == $teamID) {
					return $user->teamsystemPs4TeamPositionID;
				}
				break;
			case 3:
				if ($user->teamsystemPs3TeamID == $teamID) {
					return $user->teamsystemPs3TeamPositionID;
				}
				break;
			case 4:
				if ($user->teamsystemXb1TeamID == $teamID) {
					return $user->teamsystemXb1TeamPositionID;
				}
				break;
			case 5:
				if ($user->teamsystemXb360TeamID == $teamID) {
					return $user->teamsystemXb360TeamPositionID;
				}
				break;
		}
	
	}
	
	public function getLeaderID()  {
		return $this->leaderID;
	}
	
	public function getLeaderName() {
		$leader = new User($this->leaderID);
		return $leader;
	}
	
	public function getPlayer2ID() {
		return $this->player2ID;
	}
	
	public function getPlayer2Name() {
		$user = new User($this->player2ID);
		return $user;
	}
	
	public function getPlayer3ID() {
		return $this->player3ID;
	}
	
	public function getPlayer3Name() {
		$user = new User($this->player3ID);
		return $user;
	}
	
	public function getPlayer4ID() {
		return $this->player4ID;
	}
	
	public function getPlayer4Name() {
		$user = new User($this->player4ID);
		return $user;
	}
	
	public function getSub1ID() {
		return $this->sub1ID;
	}
	
	public function getSub1Name() {
		$user = new User($this->sub1ID);
		return $user;
	}
	
	public function getSub2ID() {
		return $this->sub2ID;
	}
	
	public function getSub2Name() {
		$user = new User($this->sub2ID);
		return $user;
	}
	
	public function getSub3ID() {
		return $this->sub3ID;
	}
	
	public function getSub3Name() {
		$user = new User($this->sub3ID);
		return $user;
	}
	
	public function getAvatar() {
	
		if ($this->avatar === null) {
	
	
					if ($this->avatarID) {
	
						if (!$this->fileHash) {
	
							$data = UserStorageHandler::getInstance()->getField('avatar', $this->teamID);
	
							if ($data === null) {
	
								$this->avatar = new TeamAvatar($this->avatarID);
	
								UserStorageHandler::getInstance()->update($this->teamID, 'avatar', serialize($this->avatar));
	
							}
	
							else {
	
								$this->avatar = unserialize($data);
	
							}
	
						}
	
						else {
	
							$this->avatar = new TeamAvatar(null, $this->getDecoratedObject()->data);
	
						}
	
					}
	
			}
	
				
	
			// use default avatar
			if ($this->avatar === null) {
	
				$this->avatar = new DefaultTeamAvatar();
	
			}
	
		return $this->avatar;
	
	}
	
	/**
	 * Returns the leader from this team
	 * @return    \wcf\data\user\User
	 */
	public function getLeader() {
		return new User($this->leaderID);
	}
	
	/**
	 * Returns the user profile from this teams leader.
	 * @return    \wcf\data\user\UserProfile
	 */
	public function getLeaderProfile() {
		return new UserProfile($this->getLeader());
	}
	
	/**
	 * Returns the contact from this team
	 * @return    \wcf\data\user\User
	 */
	public function getContact() {
		return new User($this->contactID);
	}
	
	/**
	 * Returns the user profile from this teams leader.
	 * @return    \wcf\data\user\UserProfile
	 */
	public function getContactProfile() {
		return new UserProfile($this->getContact());
	}
}