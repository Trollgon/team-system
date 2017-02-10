<?php
namespace tourneysystem\page;

use tourneysystem\data\platform\Platform;
use tourneysystem\util\TeamUtil;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use wcf\data\user\User;
use wcf\page\SortablePage;
use wcf\data\user\UserProfileList;
use tourneysystem\data\team\Team;
use tourneysystem\util\TeamInvitationUtil;
use tourneysystem\util\TeamContactsUtil;

/**
 * Shows the page of a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
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
        $platform = new Platform($this->platformID);
        $this->userOption = $platform->getPlatformUserOption();
        $userOptionName = $this->userOption->optionName;

		// checking if players set their gamertags

		$leader = new User($this->team->leaderID);
		if ($leader->getUserOption($userOptionName) == NULL && $this->team->leaderID == WCF::getUser()->getUserID()) {
            $this->missingContactInfo = true;
            $this->playerMissingContactInfo = true;
		}

		if ($this->team->player2ID != NULL) {
            $player2 = new User($this->team->player2ID);
            if ($player2->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->player2ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->player3ID != NULL) {
            $player3 = new User($this->team->player3ID);
            if ($player3->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->player3ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->player4ID != NULL) {
            $player4 = new User($this->team->player4ID);
            if ($player4->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->player4ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

		if ($this->team->sub1ID != NULL) {
		    $sub1 = new User($this->team->sub1ID);
            if ($sub1->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->sub1ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
		}

        if ($this->team->sub2ID != NULL) {
            $sub2 = new User($this->team->sub2ID);
            if ($sub2->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->sub2ID == WCF::getUser()->getUserID()) {
                $this->playerMissingContactInfo = true;
            }
        }

        if ($this->team->sub3ID != NULL) {
            $sub3 = new User($this->team->sub3ID);
            if ($sub3->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
            if ($this->team->sub3ID == WCF::getUser()->getUserID()) {
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
                  FROM tourneysystem1_user_to_team_to_position_to_platform
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
                  FROM tourneysystem1_user_to_team_to_position_to_platform
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
		if(!WCF::getSession()->getPermission("user.tourneySystem.canViewTeamPages")) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TeamList");
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$memberMissing = TeamInvitationUtil::isEmptyPosition($this->teamID, 1);
		$subMissing = TeamUtil::hasMissingSub($this->teamID);
		WCF::getTPL()->assign(array(
				'team' 						=> $this->team,
				'teamID'					=> $this->teamID,
				'platformID'				=> $this->platformID,
				'playerObjects'				=> $this->playerObjects,
				'subObjects'				=> $this->subObjects,
				'contact'					=> $this->team->getContactProfile(),
				'user'						=> $this->team->getContactProfile(),
                'userOption'                => $this->userOption,
				'playerList'				=> $this->playerList,
				'memberMissing'				=> $memberMissing,
				'subMissing'				=> $subMissing,
				'missingContactInfo'		=> $this->missingContactInfo,
				'playerMissingContactInfo'	=> $this->playerMissingContactInfo,
                'teamIsFull'	            => (!TeamInvitationUtil::isEmptyPosition($this->teamID, 1) && !TeamInvitationUtil::isEmptyPosition($this->teamID, 2)),
                'teamIsEmpty'               => ($this->team->countMembers() < 2),
		));
	}
	
}