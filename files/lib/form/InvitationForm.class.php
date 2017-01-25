<?php
namespace tourneysystem\form;

use tourneysystem\data\platform\Platform;
use wcf\data\user\UserProfileList;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use tourneysystem\data\invitations\Invitation;
use wcf\form\AbstractForm;
use tourneysystem\util\TeamInvitationUtil;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use tourneysystem\util\TeamUtil;
use tourneysystem\data\invitations\InvitationAction;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamAction;

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
	public $playerList = null;
	public $userOption = '';
	
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
		$this->platformID = $this->team->getPlatformID();
        $platform = new Platform($this->platformID);
        $this->userOption = $platform->getPlatformUserOption();

        $this->playerList = new UserProfileList();
        $this->playerList->setObjectIDs($this->team->getPlayerIDs());
        $this->playerList->readObjects();

        if($this->team->teamID == null || $this->team->teamID == 0) {
            throw new IllegalLinkException();
        }
	}

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TeamList");
    }

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.tourneySystem.canViewTeamPages")) {
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
		if (TeamUtil::isNotInTeam($this->teamID, $this->playerID)) {
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
		
		elseif (!TeamUtil::isFreePlatformPlayer($this->platformID, WCF::getUser()->userID)) {
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('InvitationList', array(
					'application' 	=> 'tourneysystem',
			)),WCF::getLanguage()->get('tourneysystem.team.join.unsuccessfulRedirect.playerAlreadyHasTeam'), 10, 'error');
		}
		
		else {
			
			$backendPositionID = TeamInvitationUtil::getFreePositionID($this->teamID, $this->positionID);
			switch ($backendPositionID) {
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
					break;
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

            $sql = "INSERT INTO tourneysystem1_user_to_team_to_position_to_platform (userID, teamID, platformID, positionID)
                  VALUES (?, ?, ?, ?)";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array(WCF::getSession()->getUser()->getUserID(), TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID()), $this->platformID, $backendPositionID));


            $invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
					'application' 	=> 'tourneysystem',
					'id'			=> TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID),
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
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
		));
	}
	
}