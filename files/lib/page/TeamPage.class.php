<?php
namespace teamsystem\page;

use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\User;
use wcf\page\SortablePage;
use wcf\data\user\UserProfileList;
use teamsystem\data\team\Team;
use teamsystem\util\TeamInvitationUtil;
use teamsystem\util\TeamContactsUtil;

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
	public $playerList = null;
	public $userOption = '';
	public $missingContactInfo = false;
	public $playerMissingContactInfo = false;
	
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
		switch ($this->platformID) {
			case 1:
				$this->userOption = "uplayName";
				break;
			case 2:
				$this->userOption = "psnID";
				break;
			case 3:
				$this->userOption = "psnID";
				break;
			case 4:
				$this->userOption = "xboxLiveID";
				break;
			case 5:
				$this->userOption = "xboxLiveID";
				break;
		}
		$leader = new User($this->team->leaderID);
		if ($leader->getUserOption($this->userOption) == NULL) {$leader = NULL; if ($this->team->leaderID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true; $this->missingContactInfo = true;}}
		if ($this->team->player2ID != NULL) {$player2 = new User($this->team->player2ID); if ($player2->getUserOption($this->userOption) == NULL) {$player2 = NULL; $this->missingContactInfo = true; if ($this->team->player2ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$player2 = null;}
		if ($this->team->player3ID != NULL) {$player3 = new User($this->team->player3ID); if ($player3->getUserOption($this->userOption) == NULL) {$player3 = NULL; $this->missingContactInfo = true; if ($this->team->player3ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$player3 = null;}
		if ($this->team->player4ID != NULL) {$player4 = new User($this->team->player4ID); if ($player4->getUserOption($this->userOption) == NULL) {$player4 = NULL; $this->missingContactInfo = true; if ($this->team->player4ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$player4 = null;}
		if ($this->team->sub1ID != NULL) {$sub1 = new User($this->team->sub1ID); if ($sub1->getUserOption($this->userOption) == NULL) {$sub1 = NULL; $this->missingContactInfo = true; if ($this->team->sub1ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$sub1 = null;}
		if ($this->team->sub2ID != NULL) {$sub2 = new User($this->team->sub2ID); if ($sub2->getUserOption($this->userOption) == NULL) {$sub2 = NULL; $this->missingContactInfo = true; if ($this->team->sub2ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$sub2 = null;}
		if ($this->team->sub3ID != NULL) {$sub3 = new User($this->team->sub3ID); if ($sub3->getUserOption($this->userOption) == NULL) {$sub3 = NULL; $this->missingContactInfo = true; if ($this->team->sub2ID == WCF::getUser()->getUserID()) {$this->playerMissingContactInfo = true;}}} else {$sub3 = null;}
		if ($leader != NULL || $player2 != NULL || $player3 != NULL || $player4 != NULL || $sub1 != NULL || $sub2 != NULL || $sub3 != NULL) {
			$this->playerList = array(
					0	=>	$leader,
					1	=>	$player2,
					2	=>	$player3,
					3	=>	$player4,
					4	=>	$sub1,
					5	=>	$sub2,
					6	=>	$sub3,
			);
		}
		else {
			$this->playerList = NULL;
		}
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
		
		$memberMissing = TeamInvitationUtil::isEmptyPosition($this->teamID, 1);
		$subMissing = TeamContactsUtil::hasMissingSub($this->teamID);
		WCF::getTPL()->assign(array(
				'team' 						=> $this->team,
				'teamID'					=> $this->teamID,
				'platformID'				=> $this->platformID,
				'playerObjects'				=> $this->playerObjects,
				'subObjects'				=> $this->subObjects,
				'contact'					=> $this->team->getContactProfile(),
				'user'						=> $this->team->getContactProfile(),
				'playerList'				=> $this->playerList,
				'userOption'				=> $this->userOption,
				'memberMissing'				=> $memberMissing,
				'subMissing'				=> $subMissing,
				'missingContactInfo'		=> $this->missingContactInfo,
				'playerMissingContactInfo'	=> $this->playerMissingContactInfo,
		));
	}
	
}