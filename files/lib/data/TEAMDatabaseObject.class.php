<?php
namespace tourneysystem\data;

use wcf\data\DatabaseObject;
use wcf\system\WCF;
use wcf\system\request\IRouteController;
use wcf\data\user\User;

/*--------------------------------------------------------------------------------------------------
File       : NEWSDatabaseObject.class.php
Description: News database object class
Copyright  : Olaf Braun © 2015
Author     : Olaf Braun
Last edit  : 01.03.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class TEAMDatabaseObject extends DatabaseObject implements IRouteController{

	/**
	 * @see    \wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'tourneysystem1_'.static:: $databaseTableName;
	}
	
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
				if ($user->tourneysystemPcTeamID == $teamID) {
					return $user->tourneysystemPcTeamPositionID;
				}
				break;
			case 2:
				if ($user->tourneysystemPs4TeamID == $teamID) {
					return $user->tourneysystemPs4TeamPositionID;
				}
				break;
			case 3:
				if ($user->tourneysystemPs3TeamID == $teamID) {
					return $user->tourneysystemPs3TeamPositionID;
				}
				break;
			case 4:
				if ($user->tourneysystemXb1TeamID == $teamID) {
					return $user->tourneysystemXb1TeamPositionID;
				}
				break;
			case 5:
				if ($user->tourneysystemXb360TeamID == $teamID) {
					return $user->tourneysystemXb360TeamPositionID;
				}
				break;
		}
				
	}
}