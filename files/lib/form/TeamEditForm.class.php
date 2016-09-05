<?php
namespace teamsystem\form;

use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\WCF;
use wcf\system\request\LinkHandler;
use teamsystem\data\team\TeamAction;
use teamsystem\data\team\Team;
use wcf\system\exception\IllegalLinkException;
use wcf\data\user\User;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;
use teamsystem\util\TeamInvitationUtil;

/**
 * Shows the Form to create a new team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamEditForm extends AbstractForm {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see    \wcf\page\AbstractPage::$loginRequired
	 */
	public 	$loginRequired = true;
	
	public	$templateName = "teamEdit";
	
	public 	$team = null;
	public 	$teamID = '';
	public	$platform = '';
	public 	$contact = 0;
	public 	$contactID = 0;
	public 	$description = '';
	public	$playerList = null;
	public	$userOption = '';

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
			$this->description = $this->team->teamDescription;
			if($this->team->teamID == null || $this->team->teamID == 0) {
				throw new IllegalLinkException();
			}
	}
	
	/**
	 * @see \wcf\form\AbstractForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		if (isset($_POST['contact'])) {
			$this->contact = StringUtil::trim($_POST['contact']);
		}
		if (isset($_POST['description'])) {
			$this->description = StringUtil::trim($_POST['description']);
		}
	}
	
	/**
	 * @see	wcf\form\IForm::validate()
	*/
	public function validate() {
		parent::validate();
		if (strlen($this->description) > 400) {
			throw new UserInputException('description');
		}
	} 
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();
		switch ($this->contact) {
			case 0:
				$this->contactID = $this->team->getLeaderID();
				break;
			case 1:
				$this->contactID = $this->team->getPlayer2ID();
				break;
			case 2:
				$this->contactID = $this->team->getPlayer3ID();
				break;
			case 3:
				$this->contactID = $this->team->getPlayer4ID();
				break;
			case 4:
				$this->contactID = $this->team->getSub1ID();
				break;
			case 5:
				$this->contactID = $this->team->getSub2ID();
				break;
			case 6:
				$this->contactID = $this->team->getSub3ID();
				break;		
		}
		
		$data = array(
		'data' => array(
			'teamDescription'		=> $this->description, 
			'contactID'				=> $this->contactID, 
			),
		);
		$action = new TeamAction(array($this->teamID), 'update', $data);
		$action->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
			'application' 	=> 'teamsystem',
			'id'			=> $this->teamID,
		)),WCF::getLanguage()->get('teamsystem.team.edit.successfulRedirect'), 10);				
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'team'			=> $this->team,
			'teamID'		=> $this->teamID,
			'platform' 		=> $this->platform,
			'contactForm'	=> $this->team->getPositionID($this->team->contactID, $this->team->getPlatformID(), $this->teamID),
			'description'	=> $this->description,
			'contact'		=> $this->team->getContactProfile(),
			'user'			=> $this->team->getContactProfile(),
			'playerList'	=> $this->playerList,
			'userOption'	=> $this->userOption,
			'teamIsFull'	=> (!TeamInvitationUtil::isEmptyPosition($this->teamID, 1) && !TeamInvitationUtil::isEmptyPosition($this->teamID, 2))
		));
	}

}
