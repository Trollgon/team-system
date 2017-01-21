<?php
namespace teamsystem\form;

use teamsystem\data\platform\Platform;
use wcf\data\user\UserProfileList;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\exception\IllegalLinkException;
use wcf\system\page\PageLocationManager;
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
class TeamKickForm extends AbstractForm {
	
	public $accept = false;
	
	public $platformID = 0;
	public $team = null;
	public $teamID = 0;
	public $playerID = 0;
	public $player = null;
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
		if(isset($_REQUEST['positionID']))
			$this->positionID = intval($_REQUEST['positionID']);
			if($this->positionID < 1 || $this->positionID > 6) {
				throw new IllegalLinkException();
			}
		$this->team = new Team($this->teamID);
		switch ($this->positionID) {
			case 1:
				$this->playerID = $this->team->getPlayer2ID();
				break;
			case 2:
				$this->playerID = $this->team->getPlayer3ID();
				break;
			case 3:
				$this->playerID = $this->team->getPlayer4ID();
				break;
			case 4:
				$this->playerID = $this->team->getSub1ID();
				break;
			case 5:
				$this->playerID = $this->team->getSub2ID();
				break;
			case 6:
				$this->playerID = $this->team->getSub3ID();
				break;
		}
		$this->player = new User($this->playerID);
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

        PageLocationManager::getInstance()->addParentLocation('de.trollgon.teamsystem.TeamKickList', $this->teamID, $this->team);
        PageLocationManager::getInstance()->addParentLocation('de.trollgon.teamsystem.TeamPage', $this->teamID, $this->team);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.teamsystem.TeamList");
    }

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if (!$this->team->isTeamLeader()) {
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
		switch ($this->positionID) {
				case 1:
					$data = array(
						'data' => array(
							'player2ID'		=> NULL,
							),
						);
					break;
				case 2:
					$data = array(
						'data' => array(
							'player3ID'		=> NULL,
							),
						);
					break;
				case 3:
					$data = array(
						'data' => array(
							'player4ID'		=> NULL,
							),
						);
					break;
				case 4:
					$data = array(
						'data' => array(
							'sub1ID'	=> NULL,
							),
						);
					break;
				case 5:
					$data = array(
						'data' => array(
							'sub2ID'	=> NULL,
							),
						);
                    break;
				case 6:
					$data = array(
						'data' => array(
							'sub3ID'	=> NULL,
							),
						);
					break;
			}
			
        $action = new TeamAction(array($this->teamID), 'update', $data);
        $action->executeAction();

        $sql = "DELETE FROM teamsystem1_user_to_team_to_position_to_platform 
                  WHERE teamID = ? AND platformID = ? AND positionID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->teamID, $this->platformID, $this->positionID));

        if ($this->team->countMembers() > 1) {
            HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamKickList', array(
                'application' 	=> 'teamsystem',
                'teamID'		=> $this->teamID,
            )),WCF::getLanguage()->get('teamsystem.team.kick.successfulRedirect'), 10);
        }
        else {
            HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
                'application' 	=> 'teamsystem',
                'teamID'		=> $this->teamID,
            )),WCF::getLanguage()->get('teamsystem.team.kick.successfulRedirect'), 10);
        }
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
				'player'		=> $this->player,
				'playerID'		=> $this->playerID,
				'positionID'	=> $this->positionID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
				'playerList'	=> $this->playerList,
				'userOption'	=> $this->userOption,
				'playername'	=> $this->player->getUsername(),
		));
	}
	
}