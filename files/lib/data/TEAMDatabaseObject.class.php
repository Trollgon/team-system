<?php
namespace tourneysystem\data;

use wcf\data\DatabaseObject;
use wcf\system\WCF;

/*--------------------------------------------------------------------------------------------------
File       : NEWSDatabaseObject.class.php
Description: News database object class
Copyright  : Olaf Braun © 2015
Author     : Olaf Braun
Last edit  : 01.03.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class TEAMDatabaseObject extends DatabaseObject {

	/**
	 * @see    \wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'tourneysystem1_'.static:: $databaseTableName;
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
}