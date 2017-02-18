<?php
namespace tourneysystem\form;

use tourneysystem\data\platform\Platform;
use tourneysystem\util\TeamInvitationUtil;
use wcf\data\user\UserProfileList;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamAction;

/**
 * Shows the Form to delete a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamDeleteForm extends AbstractForm {
	
	public $accept = false;
	
	public $platformID = 0;
	public $team = null;
	public $teamID = 0;
	public $positionID = 0;
	public $playerList = null;
	public $userOption = '';
	
	/**
	 * @see \wcf\form\AbstractForm::readParameters()
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
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }


    /**
	 * @see \wcf\form\AbstractForm::show()
	 */
	public function show() {
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

		$action = new TeamAction(array($this->teamID), 'delete');
		$action->executeAction();
			
        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamList', array(
				'application' 	=> 'tourneysystem',
		)),WCF::getLanguage()->get('tourneysystem.team.delete.successfulRedirect'), 10);
		exit;
    }
	
	/**
	 * @see \wcf\form\AbstractForm::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'team' 			=> $this->team,
				'teamID'		=> $this->teamID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
                'teamIsFull'	=> (!TeamInvitationUtil::isEmptyPosition($this->teamID, 1) && !TeamInvitationUtil::isEmptyPosition($this->teamID, 2)),
                'teamIsEmpty'   => ($this->team->countMembers() < 2),
		));
	}
	
}