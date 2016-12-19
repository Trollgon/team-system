<?php
namespace teamsystem\form;

use wcf\data\user\UserProfileList;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use wcf\data\user\UserAction;
use teamsystem\data\team\Team;
use teamsystem\data\team\TeamAction;
use wcf\data\user\User;

/**
 * Shows the Form to leave a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamLeaveForm extends AbstractForm {
	
	public $accept = false;
	
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
		
		if(isset($_REQUEST['teamID']))
			$this->teamID = intval($_REQUEST['teamID']);
		if($this->teamID == 0) {
			throw new IllegalLinkException();
		}
		$this->playerID = WCF::getUser()->getUserID();
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
		if (!$this->team->isTeamMember()) {
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
		if ($this->team->player2ID == $this->playerID) {
			$data = array(
					'data' => array(
							'player2ID'		=> NULL,
					),
			);
		}
		if ($this->team->player3ID == $this->playerID) {
			$data = array(
					'data' => array(
							'player3ID'		=> NULL,
					),
			);
		}
		if ($this->team->player4ID == $this->playerID) {
			$data = array(
					'data' => array(
							'player4ID'		=> NULL,
					),
			);
		}
		if ($this->team->sub1ID == $this->playerID) {
			$data = array(
					'data' => array(
							'sub1ID'		=> NULL,
					),
			);
		}
		if ($this->team->sub2ID == $this->playerID) {
			$data = array(
					'data' => array(
							'sub2ID'		=> NULL,
					),
			);
		}
		if ($this->team->sub3ID == $this->playerID) {
			$data = array(
					'data' => array(
							'sub3ID'		=> NULL,
					),
			);
		}
			
        $action = new TeamAction(array($this->teamID), 'update', $data);
        $action->executeAction();

        $sql = "DELETE FROM teamsystem1_user_to_team_to_position_to_platform 
                  WHERE userID = ? AND teamID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array(WCF::getUser()->getUserID(), $this->teamID));

		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamList', array(
				'application' 	=> 'teamsystem',
		)),WCF::getLanguage()->get('teamsystem.team.leave.successfulRedirect'), 10);
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
				'playerID'		=> $this->playerID,
				'positionID'	=> $this->positionID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
		));
	}
	
}