<?php
namespace tourneysystem\form;

use tourneysystem\data\platform\Platform;
use wcf\data\user\UserProfileList;
use wcf\form\AbstractForm;
use wcf\system\page\PageLocationManager;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\WCF;
use wcf\system\request\LinkHandler;
use tourneysystem\data\team\TeamAction;
use tourneysystem\data\team\Team;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;

/**
 * Shows the Form to create a new team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamEditForm extends AbstractForm {
	
	public	$templateName = "teamEdit";
	
	public 	$team = null;
	public 	$teamID = '';
	public	$platformID = '';
	public 	$contact = 0;
	public 	$contactID = 0;
	public 	$description = '';
	public	$playerList = null;
	public	$userOption = '';

	/**
	 * @see \wcf\page\AbstractPage::show()
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
	 * @see \wcf\page\AbstractPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if(isset($_REQUEST['teamID'])) $this->teamID = intval($_REQUEST['teamID']);
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
	 * @see \wcf\form\AbstractForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		if (isset($_POST['contact'])) {
			$this->contact = StringUtil::trim($_POST['contact']);
		}
		if (isset($_POST['description'])) {
			$this->description = StringUtil::trim($_POST['description']);
		}
	}
	
	/**
	 * @see	wcf\form\AbstractForm::validate()
	*/
	public function validate() {
		parent::validate();
		if (strlen($this->description) > 400) {
			throw new UserInputException('description');
		}
	} 
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();
		switch ($this->contact) {
			case 0:
				$this->contactID = $this->team->getLeaderID();
				break;
			case 1:
				$this->contactID = $this->team->getPlayer2ID();
				break;
			case 2:
				$this->contactID = $this->team->getPlayer3ID();
				break;
			case 3:
				$this->contactID = $this->team->getPlayer4ID();
				break;
			case 4:
				$this->contactID = $this->team->getSub1ID();
				break;
			case 5:
				$this->contactID = $this->team->getSub2ID();
				break;
			case 6:
				$this->contactID = $this->team->getSub3ID();
				break;		
		}
		
		$data = array(
		'data' => array(
			'teamDescription'		=> $this->description, 
			'contactID'				=> $this->contactID, 
			),
		);
		$action = new TeamAction(array($this->teamID), 'update', $data);
		$action->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
			'application' 	=> 'tourneysystem',
			'id'			=> $this->teamID,
		)),WCF::getLanguage()->get('tourneysystem.team.edit.successfulRedirect'), 10);
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'team'			=> $this->team,
			'teamID'		=> $this->teamID,
			'platform' 		=> $this->platformID,
			'contactForm'	=> $this->team->getPositionID($this->team->contactID, $this->team->getPlatformID(), $this->teamID),
			'description'	=> $this->description,
			'contact'		=> $this->team->getContactProfile(),
			'user'			=> $this->team->getContactProfile(),
			'playerList'	=> $this->playerList,
			'userOption'	=> $this->userOption,
		));
	}

}
