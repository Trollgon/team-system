<?php
namespace tourneysystem\form;

use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use tourneysystem\data\invitations\InvitationAction;
use tourneysystem\data\team\PcTeam;
use tourneysystem\data\team\Ps4Team;
use tourneysystem\data\team\Ps3Team;
use tourneysystem\data\team\Xb1Team;
use tourneysystem\data\team\Xb360Team;
use tourneysystem\util\TeamInvitationUtil;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;

/**
 * Shows the Form to invite a member to a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamInvitationForm extends AbstractForm {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public	$activeMenuItem = 'tourneysystem.header.menu.teams';
	
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
		if(isset($_REQUEST['platformID']))
			$this->platformID = intval($_REQUEST['platformID']);
		if($this->teamID == 0) {
			throw new IllegalLinkException();
			}
		if($this->platformID == 0) {
			throw new IllegalLinkException();
		}
		switch ($this->platformID) {
			case 1:
				$this->team = new PcTeam($this->teamID);
				break;
			case 2:
				$this->team = new Ps4Team($this->teamID);
				break;
			case 3:
				$this->team = new Ps3Team($this->teamID);
				break;
			case 4:
				$this->team = new Xb1Team($this->teamID);
				break;
			case 5:
				$this->team = new Xb360Team($this->teamID);
				break;
		}
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
		if (!TeamInvitationUtil::isNotInTeam($this->platformID, $this->teamID, $this->playerID)) {
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
				'application' 	=> 'tourneysystem',
				'teamID'		=> $this->teamID,
				'platformID'	=> $this->platformID,
		)),WCF::getLanguage()->get('tourneysystem.team.invitation.successfulRedirect'), 10);
		exit;
	}
	
	/**
	 * @see \wcf\form\AbstractForm::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'positionID'	=> $this->positionID,
				'formData' 		=> $this->formData,
				'playername' 	=> $this->playername,
				'teamID'		=> $this->teamID,
				'platformID'	=> $this->platformID
		));
	}

}