<?php

namespace tourneysystem\data\invitations;

use wcf\data\DatabaseObject;
use wcf\system\WCF;
use wcf\system\request\IRouteController;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use tourneysystem\data\team\PcTeam;
use tourneysystem\data\team\Ps4Team;
use tourneysystem\data\team\Ps3Team;
use tourneysystem\data\team\Xb1Team;
use tourneysystem\data\team\Xb360Team;

class Invitation extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
	
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
	
	public function getTeamName() {
		switch ($this->platformID) {
			case 1:
				$team = new PcTeam($this->teamID);
				break;
			case 2:
				$team = new Ps4Team($this->teamID);
				break;
			case 3:
				$team = new Ps3Team($this->teamID);
				break;
			case 4:
				$team = new Xb1Team($this->teamID);
				break;
			case 5:
				$team = new Xb360Team($this->teamID);
				break;
		}
		return $team->getTeamName();
	}
	
	public function getTeamPlatformID() {
		return $this->platformID;
	}
	
	public function getPlayerID() {
		return $this->playerID;
	}
	
}