<?php
namespace teamsystem\form;

use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use wcf\data\user\UserAction;
use teamsystem\data\team\Team;
use teamsystem\data\team\TeamAction;
use wcf\data\user\User;

/**
 * Shows the Form to delete a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamDeleteForm extends AbstractForm {
	
	public $accept = false;
	
	public $platformID = 0;
	public $team = null;
	public $teamID = 0;
	public $positionID = 0;
	public $playerList = null;
	public $userOption = '';
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see \wcf\page\AbstractPage::$loginRequired
	 */
	public	$loginRequired = true;
	
	/**
	 * @see \wcf\page\AbstractPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if(isset($_REQUEST['teamID']))
			$this->teamID = intval($_REQUEST['teamID']);
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
		if ($leader->getUserOption($this->userOption) == NULL) {$leader = NULL;}
		if ($this->team->player2ID != NULL) {$player2 = new User($this->team->player2ID); if ($player2->getUserOption($this->userOption) == NULL) {$player2 = NULL;}} else {$player2 = null;}
		if ($this->team->player3ID != NULL) {$player3 = new User($this->team->player3ID); if ($player3->getUserOption($this->userOption) == NULL) {$player3 = NULL;}} else {$player3 = null;}
		if ($this->team->player4ID != NULL) {$player4 = new User($this->team->player4ID); if ($player4->getUserOption($this->userOption) == NULL) {$player4 = NULL;}} else {$player4 = null;}
		if ($this->team->sub1ID != NULL) {$sub1 = new User($this->team->sub1ID); if ($sub1->getUserOption($this->userOption) == NULL) {$sub1 = NULL;}} else {$sub1 = null;}
		if ($this->team->sub2ID != NULL) {$sub2 = new User($this->team->sub2ID); if ($sub2->getUserOption($this->userOption) == NULL) {$sub2 = NULL;}} else {$sub2 = null;}
		if ($this->team->sub3ID != NULL) {$sub3 = new User($this->team->sub3ID); if ($sub3->getUserOption($this->userOption) == NULL) {$sub3 = NULL;}} else {$sub3 = null;}
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
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if (!$this->team->isTeamLeader()) {
				WCF::getSession()->checkPermissions(array("mod.teamSystem.canEditTeams"));
			}
		else {
			if (TEAMSYSTEM_LOCK_TEAMEDIT == true) {
				throw new PermissionDeniedException();
			}
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\form\AbstractForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['accept'])) {
			$this->accept = true;
		}
	}
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();

		$action = new TeamAction(array($this->teamID), 'delete');
		$action->executeAction();
			switch ($this->platformID) {
				case 1:
					$userdata = array(
							'data' => array(
									'teamsystemPcTeamID' 		=> NULL,
									'teamsystemPcTeamPositionID' => NULL,
							)
					);
					break;
				case 2:
					$userdata = array(
							'data' => array(
									'teamsystemPs4TeamID' 			=> NULL,
									'teamsystemPs4TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 3:
					$userdata = array(
							'data' => array(
									'teamsystemPs3TeamID' 			=> NULL,
									'teamsystemPs3TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 4:
					$userdata = array(
							'data' => array(
									'teamsystemXb1TeamID' 			=> NULL,
									'teamsystemXb1TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 5:
					$userdata = array(
							'data' => array(
									'teamsystemXb360TeamID' 			=> NULL,
									'teamsystemXb360TeamPositionID' 	=> NULL,
							)
					);
					break;
			}
			$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
			$userAction->executeAction();
			
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamList', array(
					'application' 	=> 'teamsystem',
			)),WCF::getLanguage()->get('teamsystem.team.delete.successfulRedirect'), 10);
			exit;
		}
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'team' 			=> $this->team,
				'teamID'		=> $this->teamID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
		));
	}
	
}