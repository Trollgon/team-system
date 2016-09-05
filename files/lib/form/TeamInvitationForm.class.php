<?php
namespace teamsystem\form;

use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use teamsystem\data\invitations\InvitationAction;
use teamsystem\util\TeamInvitationUtil;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;
use teamsystem\data\team\Team;
use wcf\system\exception\PermissionDeniedException;

/**
 * Shows the Form to invite a member to a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamInvitationForm extends AbstractForm {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public	$activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see \wcf\page\AbstractPage::$loginRequired
	 */
	public	$loginRequired = true;
	
	public	$team = '';
	
	public	$platformID = '';
	public 	$teamID = '';
	public 	$playername = '';
	public 	$positionID = '';
	public	$playerID = '';
	public 	$player = '';
	public 	$playerList = null;
	public 	$userOption = '';
	
	public  $formData = array(
			'teamID'		=> '',
			'platformID'	=> '',
			'playerID'		=> '',
			'positionID'	=> '',
	);
	
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
		if (!TeamInvitationUtil::isEmptyPosition($this->teamID, 1) && !TeamInvitationUtil::isEmptyPosition($this->teamID, 2)) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\form\AbstractForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		if (isset($_POST['positionID'])) {
			$this->positionID = StringUtil::trim($_POST['positionID']);
			$this->formData['positionID'] = StringUtil::trim($_POST['positionID']);
		}
		if (isset($_POST['playername'])) {
			$this->playername = StringUtil::trim($_POST['playername']);
			$this->player = User::getUserByUsername($this->playername);
		}
		
		$this->formData['platformID'] = $this->platformID;
		$this->formData['teamID'] = $this->teamID;
	}
	
	/**
	 * @see	wcf\form\IForm::validate()
	 */
	public function validate() {
		if ($this->positionID == 0) {
			throw new UserInputException('positionID');
		}
		
		// check if the position is empty
		if (!TeamInvitationUtil::isEmptyPosition($this->teamID, $this->positionID)) {
			throw new UserInputException('positionID', 'notUnique');
		}
		
		if (empty($this->playername)) {
			throw new UserInputException('playername');
		}
		
		//check if the player exists
		if (($this->player->getUserID() == 0)) {
			throw new UserInputException('playername', 'notValid');
		}
		
		$this->playerID = $this->player->getUserID();
		$this->formData['playerID'] = $this->player->getUserID();
				
		// check if the player is not already in the team
		if (!TeamInvitationUtil::isNotInTeam($this->teamID, $this->playerID)) {
			throw new UserInputException('playername', 'notUnique');
		}
	}
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();
		$data = array(
				'data' => array(
						'teamID'		=> $this->formData['teamID'],
						'platformID'	=> $this->formData['platformID'],
						'playerID'		=> $this->formData['playerID'],
						'positionID'	=> $this->formData['positionID'],
				),
		);
		$action = new InvitationAction(array(), 'create', $data);
		$action->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('teamInvitation', array(
				'application' 	=> 'teamsystem',
				'teamID'		=> $this->teamID,
		)),WCF::getLanguage()->get('teamsystem.team.invitation.successfulRedirect'), 10);
		exit;
	}
	
	/**
	 * @see \wcf\form\AbstractForm::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'team'			=> $this->team,
				'positionID'	=> $this->positionID,
				'formData' 		=> $this->formData,
				'playername' 	=> $this->playername,
				'teamID'		=> $this->teamID,
				'platformID'	=> $this->platformID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
		));
	}

}