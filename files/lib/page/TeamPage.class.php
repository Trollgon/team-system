<?php
namespace teamsystem\page;

use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\page\AbstractPage;
use wcf\data\user\User;
use wcf\page\SortablePage;
use wcf\data\user\UserProfileList;
use teamsystem\data\team\Team;

/**
 * Shows the page of a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */

class TeamPage extends SortablePage {
	
	public $teamID = 0;
	public $team = null;
	public $platformID = 0;
	public $objectTypeID = 0;
	
	public $playerObjects = null;
	public $subObjects = null;
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */
	
	public $objectListClassName = 'wcf\data\user\UserProfileList';
	
	/**
	 * @see \wcf\page\AbstractPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if(isset($_REQUEST['id']))
			$this->teamID = intval($_REQUEST['id']);
		if($this->teamID == 0) {
			throw new IllegalLinkException();
		}
		$this->team = new Team($this->teamID);
		$this->platformID = $this->team->getPlatformID();
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	protected function initObjectList() {
		parent::initObjectList();
	
		$this->playerObjects = new UserProfileList();
		
		switch ($this->platformID) {
			case 1:
				$this->playerObjects->getConditionBuilder()->add("teamsystemPcTeamID = ?", array($this->teamID));
				$this->playerObjects->getConditionBuilder()->add("teamsystemPcTeamPositionID < ?", array("4"));
				break;
			case 2:
				$this->playerObjects->getConditionBuilder()->add("teamsystemPs4TeamID = ?", array($this->teamID));
				$this->playerObjects->getConditionBuilder()->add("teamsystemPs4TeamPositionID < ?", array("4"));
				break;
			case 3:
				$this->playerObjects->getConditionBuilder()->add("teamsystemPs3TeamID = ?", array($this->teamID));
				$this->playerObjects->getConditionBuilder()->add("teamsystemPs3TeamPositionID < ?", array("4"));
				break;
			case 4:
				$this->playerObjects->getConditionBuilder()->add("teamsystemXb1TeamID = ?", array($this->teamID));
				$this->playerObjects->getConditionBuilder()->add("teamsystemXb1TeamPositionID < ?", array("4"));
				break;
			case 5:
				$this->playerObjects->getConditionBuilder()->add("teamsystemXb360TeamID = ?", array($this->teamID));
				$this->playerObjects->getConditionBuilder()->add("teamsystemXb360TeamPositionID < ?", array("4"));
				break;
		}
		
		$this->playerObjects->readObjects();
		
		$this->subObjects = new UserProfileList();
		
		switch ($this->platformID) {
			case 1:
				$this->subObjects->getConditionBuilder()->add("teamsystemPcTeamID = ?", array($this->teamID));
				$this->subObjects->getConditionBuilder()->add("teamsystemPcTeamPositionID > ?", array("3"));
				break;
			case 2:
				$this->subObjects->getConditionBuilder()->add("teamsystemPs4TeamID = ?", array($this->teamID));
				$this->subObjects->getConditionBuilder()->add("teamsystemPs4TeamPositionID > ?", array("3"));
				break;
			case 3:
				$this->subObjects->getConditionBuilder()->add("teamsystemPs3TeamID = ?", array($this->teamID));
				$this->subObjects->getConditionBuilder()->add("teamsystemPs3TeamPositionID > ?", array("3"));
				break;
			case 4:
				$this->subObjects->getConditionBuilder()->add("teamsystemXb1TeamID = ?", array($this->teamID));
				$this->subObjects->getConditionBuilder()->add("teamsystemXb1TeamPositionID > ?", array("3"));
				break;
			case 5:
				$this->subObjects->getConditionBuilder()->add("teamsystemXb360TeamID = ?", array($this->teamID));
				$this->subObjects->getConditionBuilder()->add("teamsystemXb360TeamPositionID > ?", array("3"));
				break;
		}
		
		$this->subObjects->readObjects();
		
	}

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canViewTeamPages")) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	
	public function assignVariables() {
		parent::assignVariables();
		

		
		WCF::getTPL()->assign(array(
				'team' 				=> $this->team,
				'teamID'			=> $this->teamID,
				'platformID'		=> $this->platformID,
				'playerObjects'		=> $this->playerObjects,
				'subObjects'		=> $this->subObjects,
				'contact'			=> $this->team->getContactProfile(),
				'user'				=> $this->team->getContactProfile(),

		));
	}
	
}