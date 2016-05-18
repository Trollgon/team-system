<?php
namespace tourneysystem\form;

use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\UserAction;
use tourneysystem\data\team\PcTeam;
use tourneysystem\data\team\Ps4Team;
use tourneysystem\data\team\Ps3Team;
use tourneysystem\data\team\Xb1Team;
use tourneysystem\data\team\Xb360Team;
use tourneysystem\data\team\PcTeamAction;
use tourneysystem\data\team\Ps4TeamAction;
use tourneysystem\data\team\Ps3TeamAction;
use tourneysystem\data\team\Xb1TeamAction;
use tourneysystem\data\team\Xb360TeamAction;
use wcf\page\AbstractPage;
use tourneysystem\data\invitations\Invitation;
use wcf\form\AbstractForm;
use tourneysystem\util\TeamInvitationUtil;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use tourneysystem\util\TeamUtil;
use tourneysystem\data\invitations\InvitationAction;

/**
 * Shows the page of an invitation.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
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
	public $activeMenuItem = 'tourneysystem.header.menu.teams';
	
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
		
		if (TeamInvitationUtil::isEmptyPosition($this->platformID, $this->teamID, $this->positionID)) {
			$this->positionNotEmpty = true;
		}
		if (TeamInvitationUtil::isNotInTeam($this->platformID, $this->teamID, $this->playerID)) {
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
					'application' 	=> 'tourneysystem',
			)),WCF::getLanguage()->get('tourneysystem.team.join.unsuccessfulRedirect.positionNotEmpty'), 10, 'error');
		}
		
		elseif ($this->playerNotInThisTeam == false) {
			
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('InvitationList', array(
					'application' 	=> 'tourneysystem',
			)),WCF::getLanguage()->get('tourneysystem.team.join.unsuccessfulRedirect.playerNotInThisTeam'), 10, 'error');
		}
		
		else {
			
			switch ($this->positionID) {
				case 1:
					$data = array(
						'data' => array(
							'player2ID'		=> WCF::getUser()->getUserID(),
							'player2Name'	=> WCF::getUser()->getUsername(),
							),
						);
					break;
				case 2:
					$data = array(
						'data' => array(
							'player3ID'		=> WCF::getUser()->getUserID(),
							'player3Name'	=> WCF::getUser()->getUsername(),
							),
						);
					break;
				case 3:
					$data = array(
						'data' => array(
							'player4ID'		=> WCF::getUser()->getUserID(),
							'player4Name'	=> WCF::getUser()->getUsername(),
							),
						);
					break;
				case 4:
					$data = array(
						'data' => array(
							'sub1ID'	=> WCF::getUser()->getUserID(),
							'sub1Name'	=> WCF::getUser()->getUsername(),
							),
						);
					break;
				case 5:
					$data = array(
						'data' => array(
							'sub2ID'	=> WCF::getUser()->getUserID(),
							'sub2Name'	=> WCF::getUser()->getUsername(),
							),
						);
				case 6:
					$data = array(
						'data' => array(
							'sub3ID'	=> WCF::getUser()->getUserID(),
							'sub3Name'	=> WCF::getUser()->getUsername(),
							),
						);
					break;
			}
			
			switch ($this->platformID) {
				case 1:
					$action = new PcTeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'tourneysystemPcTeamID' => $userTeamID,
							)
					);
					break;
				case 2:
					$action = new Ps4TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'tourneysystemPs4TeamID' => $userTeamID,
							)
					);
					break;
				case 3:
					$action = new Ps3TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'tourneysystemPs3TeamID' => $userTeamID,
							)
					);
					break;
				case 4:
					$action = new Xb1TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'tourneysystemXb1TeamID' => $userTeamID,
							)
					);
					break;
				case 5:
					$action = new Xb360TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userTeamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID);
					$userdata = array(
							'data' => array(
									'tourneysystemXb360TeamID' => $userTeamID,
							)
					);
					break;
			}
			$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
			$userAction->executeAction();
			
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
					'application' 	=> 'tourneysystem',
					'teamID'		=> TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID),
					'platformID'	=> $this->platformID,
			)),WCF::getLanguage()->get('tourneysystem.team.join.successfulRedirect'), 10);
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