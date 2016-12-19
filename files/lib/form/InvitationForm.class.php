<?php
namespace teamsystem\form;

use wcf\data\user\UserProfileList;
use wcf\system\breadcrumb\Breadcrumb;
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
use wcf\data\user\User;

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

        // checking if players set their gamertags

        $leader = new User($this->team->leaderID);
        if ($leader->getUserOption($this->userOption) == NULL && $this->team->leaderID == WCF::getUser()->getUserID()) {
            $this->missingContactInfo = true;
            $this->playerMissingContactInfo = true;
        }

        if ($this->team->player2ID != NULL) {
            $player2 = new User($this->team->player2ID);
            if ($player2->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->player2ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->player3ID != NULL) {
            $player3 = new User($this->team->player3ID);
            if ($player3->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->player3ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->player4ID != NULL) {
            $player4 = new User($this->team->player4ID);
            if ($player4->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->player4ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->sub1ID != NULL) {
            $sub1 = new User($this->team->sub1ID);
            if ($sub1->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->sub1ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->sub2ID != NULL) {
            $sub2 = new User($this->team->sub2ID);
            if ($sub2->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->sub2ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->sub3ID != NULL) {
            $sub3 = new User($this->team->sub3ID);
            if ($sub3->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
            elseif ($this->team->sub3ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

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

        WCF::getBreadcrumbs()->add(new Breadcrumb($this->team->teamName, LinkHandler::getInstance()->getLink('Team', array(
            'application' 	=> 'teamsystem',
            'id'            => $this->teamID
        ))));
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
		
		elseif (!TeamUtil::isFreePlatformPlayer($this->platformID, WCF::getUser()->userID)) {
			$invitationAction = new InvitationAction(array($this->invitationID), 'delete');
			$invitationAction->executeAction();
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('InvitationList', array(
					'application' 	=> 'teamsystem',
			)),WCF::getLanguage()->get('teamsystem.team.join.unsuccessfulRedirect.playerAlreadyHasTeam'), 10, 'error');
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

            $sql = "INSERT INTO teamsystem1_user_to_team_to_position_to_platform (userID, teamID, platformID, positionID)
                  VALUES (?, ?, ?, ?)";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array(WCF::getSession()->getUser()->getUserID(), TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID()), $this->platformID, $backendPositionID));


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
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
		));
	}
	
}