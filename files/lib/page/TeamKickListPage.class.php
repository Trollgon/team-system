<?php
namespace tourneysystem\page;

use tourneysystem\data\platform\Platform;
use wcf\data\user\UserProfileList;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use wcf\page\AbstractPage;
use tourneysystem\data\team\Team;

/**
 * Shows the page of a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamKickListPage extends AbstractPage {
	
	public $teamID = 0;
	public $team = null;
	public $platformID = 0;
	public $objectTypeID = 0;
	
	public $playerObjects = null;
	public $subObjects = null;
	public $playerList = null;
	public $userOption = '';
	
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

        PageLocationManager::getInstance()->addParentLocation('de.trollgon.tourneysystem.TeamPage', $this->teamID, $this->team);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TeamList");
    }

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.tourneySystem.canCreateTeam")) {
			throw new PermissionDeniedException();
		}
		if ($this->team->countMembers() < 2) {
            throw new PermissionDeniedException();
        }
		if (!$this->team->isTeamLeader()) {
				WCF::getSession()->checkPermissions(array("mod.tourneySystem.canEditTeams"));
			}
		else {
			if (TOURNEYSYSTEM_LOCK_TEAMEDIT == true) {
				throw new PermissionDeniedException();
			}
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	
	public function assignVariables() {
		parent::assignVariables();

		WCF::getTPL()->assign(array(
				'team' 				=> $this->team,
				'teamID'			=> $this->teamID,
				'platformID'		=> $this->platformID,
				'playerObjects'		=> $this->playerObjects,
				'subObjects'		=> $this->subObjects,
				'contact'			=> $this->team->getContactProfile(),
				'user'				=> $this->team->getContactProfile(),
				'playerList'		=> $this->playerList,
				'userOption'		=> $this->userOption,
                'teamIsFull'	    => (!TeamInvitationUtil::isEmptyPosition($this->teamID, 1) && !TeamInvitationUtil::isEmptyPosition($this->teamID, 2))
		));
	}
	
}