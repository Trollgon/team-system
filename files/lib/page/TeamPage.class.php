<?php
namespace teamsystem\page;

use wcf\data\user\UserList;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\User;
use wcf\page\SortablePage;
use wcf\data\user\UserProfileList;
use teamsystem\data\team\Team;
use teamsystem\util\TeamInvitationUtil;
use teamsystem\util\TeamContactsUtil;

/**
 * Shows the page of a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */

class TeamPage extends SortablePage {
	
	public $teamID = 0;
	public $team = null;
	public $platformID = 0;
	public $objectTypeID = 0;

	public $playerObjects = null;
	public $subObjects = null;
	public $playerList = array();
	public $userOption = '';
    public $userOptionPlain = '';
	public $missingContactInfo = false;
	public $playerMissingContactInfo = false;
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */
	
	public $objectListClassName = 'wcf\data\user\UserProfileList';
	
	/**
	 * @see \wcf\page\AbstractPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if(isset($_REQUEST['id']))
			$this->teamID = intval($_REQUEST['id']);
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

        switch ($this->platformID) {
            case 1:
                $this->userOptionPlain = "Uplay";
                break;
            case 2:
                $this->userOptionPlain = "PSN ID";
                break;
            case 3:
                $this->userOptionPlain = "PSN ID";
                break;
            case 4:
                $this->userOptionPlain = "XBOX Live ID";
                break;
            case 5:
                $this->userOptionPlain = "XBOX Live ID";
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
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	protected function initObjectList() {
		parent::initObjectList();

        $sql = /** @lang MySQL */
            "SELECT userID
                  FROM teamsystem1_user_to_team_to_position_to_platform
                  WHERE teamID = ? AND positionID < 4";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->teamID));
        $playerArray = array();
        while($row = $statement->fetchArray()) {
            $playerArray[] = $row['userID'];
        }

        $this->playerObjects = new UserProfileList();
        $this->playerObjects->setObjectIDs($playerArray);
		$this->playerObjects->readObjects();

        $sql = /** @lang MySQL */
            "SELECT userID
                  FROM teamsystem1_user_to_team_to_position_to_platform
                  WHERE teamID = ? AND positionID > 3";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->teamID));
        $subArray = array();
        while($row = $statement->fetchArray()) {
            $subArray[] = $row['userID'];
        }

        $this->subObjects = new UserProfileList();
        $this->subObjects->setObjectIDs($subArray);
		$this->subObjects->readObjects();
		
	}

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canViewTeamPages")) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	
	public function assignVariables() {
		parent::assignVariables();
		
		$memberMissing = TeamInvitationUtil::isEmptyPosition($this->teamID, 1);
		$subMissing = TeamContactsUtil::hasMissingSub($this->teamID);
		WCF::getTPL()->assign(array(
				'team' 						=> $this->team,
				'teamID'					=> $this->teamID,
				'platformID'				=> $this->platformID,
				'playerObjects'				=> $this->playerObjects,
				'subObjects'				=> $this->subObjects,
				'contact'					=> $this->team->getContactProfile(),
				'user'						=> $this->team->getContactProfile(),
				'playerList'				=> $this->playerList,
				'userOption'				=> $this->userOption,
                'userOptionPlain'           => $this->userOptionPlain,
				'memberMissing'				=> $memberMissing,
				'subMissing'				=> $subMissing,
				'missingContactInfo'		=> $this->missingContactInfo,
				'playerMissingContactInfo'	=> $this->playerMissingContactInfo,
		));
	}
	
}