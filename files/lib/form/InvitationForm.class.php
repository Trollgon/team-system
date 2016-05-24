<?php
namespace teamsystem\form;

use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\UserAction;
use wcf\page\AbstractPage;
use teamsystem\data\invitations\Invitation;
use wcf\form\AbstractForm;
use teamsystem\util\TeamInvitationUtil;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use teamsystem\util\TeamUtil;
use teamsystem\data\invitations\InvitationAction;
use teamsystem\data\team\Team;
use teamsystem\data\team\TeamAction;

/**
 * Shows the page of an invitation.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */

class InvitationForm extends AbstractForm {
	
	public $accept = false;
	public $positionNotEmpty = false;
	public $playerNotInThisTeam = false;
	
	public $invitation = null;
	public $invitationID = 0;
	public $platformID = 0;
	public $team = null;
	public $teamID = 0;
	public $playerID = 0;
	public $positionID = 0;
	
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
		if(isset($_REQUEST['id']))
			$this->invitationID = intval($_REQUEST['id']);
		if($this->invitationID == 0) {
			throw new IllegalLinkException();
		}
		$this->invitation = new Invitation($this->invitationID);
		
		$this->platformID 	= $this->invitation->getTeamPlatformID();
		$this->teamID 		= $this->invitation->getTeamID();
		$this->playerID 	= $this->invitation->getPlayerID();
		$this->positionID	= $this->invitation->getPositionID();
		
		$this->team = new Team($this->teamID);
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}
	

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canViewTeamPages")) {
			throw new PermissionDeniedException();
		}
		if(!WCF::getSession()->getUser()->getUserID() == $this->playerID)
			throw new PermissionDeniedException();
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
	 * @see \wcf\form\AbstractForm::validate()
	 */
	public function validate() {
		parent::validate();
		
		if (TeamInvitationUtil::isEmptyPosition($this->teamID, $this->positionID)) {
			$this->positionNotEmpty = true;
		}
		if (TeamInvitationUtil::isNotInTeam($this->teamID, $this->playerID)) {
			$this->playerNotInThisTeam = true;
		}
	}
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();
		
		if ($this->positionNotEmpty == false) {
			
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('InvitationList', array(
					'application' 	=> 'teamsystem',
			)),WCF::getLanguage()->get('teamsystem.team.join.unsuccessfulRedirect.positionNotEmpty'), 10, 'error');
		}
		
		elseif ($this->playerNotInThisTeam == false) {
			
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('InvitationList', array(
					'application' 	=> 'teamsystem',
			)),WCF::getLanguage()->get('teamsystem.team.join.unsuccessfulRedirect.playerNotInThisTeam'), 10, 'error');
		}
		
		else {
			
			switch ($this->positionID) {
				case 1:
					$data = array(
						'data' => array(
							'player2ID'		=> WCF::getUser()->getUserID(),
							),
						);
					break;
				case 2:
					$data = array(
						'data' => array(
							'player3ID'		=> WCF::getUser()->getUserID(),
							),
						);
					break;
				case 3:
					$data = array(
						'data' => array(
							'player4ID'		=> WCF::getUser()->getUserID(),
							),
						);
					break;
				case 4:
					$data = array(
						'data' => array(
							'sub1ID'	=> WCF::getUser()->getUserID(),
							),
						);
					break;
				case 5:
					$data = array(
						'data' => array(
							'sub2ID'	=> WCF::getUser()->getUserID(),
							),
						);
				case 6:
					$data = array(
						'data' => array(
							'sub3ID'	=> WCF::getUser()->getUserID(),
							),
						);
					break;
			}
			
			$action = new TeamAction(array($this->teamID), 'update', $data);
			$action->executeAction();
			
			switch ($this->platformID) {
				case 1:
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'teamsystemPcTeamID' 		=> $userTeamID,
									'teamsystemPcTeamPositionID' => $this->positionID,
							)
					);
					break;
				case 2:
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'teamsystemPs4TeamID' 			=> $userTeamID,
									'teamsystemPs4TeamPositionID' 	=> $this->positionID,
							)
					);
					break;
				case 3:
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'teamsystemPs3TeamID' 			=> $userTeamID,
									'teamsystemPs3TeamPositionID' 	=> $this->positionID,
							)
					);
					break;
				case 4:
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'teamsystemXb1TeamID' 			=> $userTeamID,
									'teamsystemXb1TeamPositionID' 	=> $this->positionID,
							)
					);
					break;
				case 5:
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'teamsystemXb360TeamID' 			=> $userTeamID,
									'teamsystemXb360TeamPositionID' 	=> $this->positionID,
							)
					);
					break;
			}
			$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
			$userAction->executeAction();
			
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
					'application' 	=> 'teamsystem',
					'id'			=> TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID),
			)),WCF::getLanguage()->get('teamsystem.team.join.successfulRedirect'), 10);
			exit;
		}
		
	}
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'team' 			=> $this->team,
				'teamID'		=> $this->teamID,
				'platformID'	=> $this->platformID,
				'invitation'	=> $this->invitation,
				'invitationID'	=> $this->invitationID,
				'playerID'		=> $this->playerID,
				'positionID'	=> $this->positionID,
		));
	}
	
}