<?php
namespace teamsystem\form;

use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use teamsystem\data\invitations\InvitationAction;
use teamsystem\util\TeamInvitationUtil;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;
use teamsystem\data\team\Team;

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
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canCreateTeam")) {
			throw new PermissionDeniedException();
		}
		if(!($this->team->isTeamLeader())) {
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
		if (!TeamInvitationUtil::isEmptyPosition($this->platformID, $this->teamID, $this->positionID)) {
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
		));
	}

}