<?php
namespace teamsystem\form;

use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\exception\IllegalLinkException;
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
		$leader = new User($this->team->leaderID);
		if ($leader->getUserOption($this->userOption) == NULL) {$leader = NULL;}
		if ($this->team->player2ID != NULL) {$player2 = new User($this->team->player2ID); if ($player2->getUserOption($this->userOption) == NULL) {$player2 = NULL;}} else {$player2 = null;}
		if ($this->team->player3ID != NULL) {$player3 = new User($this->team->player3ID); if ($player3->getUserOption($this->userOption) == NULL) {$player3 = NULL;}} else {$player3 = null;}
		if ($this->team->player4ID != NULL) {$player4 = new User($this->team->player4ID); if ($player4->getUserOption($this->userOption) == NULL) {$player4 = NULL;}} else {$player4 = null;}
		if ($this->team->sub1ID != NULL) {$sub1 = new User($this->team->sub1ID); if ($sub1->getUserOption($this->userOption) == NULL) {$sub1 = NULL;}} else {$sub1 = null;}
		if ($this->team->sub2ID != NULL) {$sub2 = new User($this->team->sub2ID); if ($sub2->getUserOption($this->userOption) == NULL) {$sub2 = NULL;}} else {$sub2 = null;}
		if ($this->team->sub3ID != NULL) {$sub3 = new User($this->team->sub3ID); if ($sub3->getUserOption($this->userOption) == NULL) {$sub3 = NULL;}} else {$sub3 = null;}
		if ($leader != NULL || $player2 != NULL || $player3 != NULL || $player4 != NULL || $sub1 != NULL || $sub2 != NULL || $sub3 != NULL) {
			$this->playerList = array(
					0	=>	$leader,
					1	=>	$player2,
					2	=>	$player3,
					3	=>	$player4,
					4	=>	$sub1,
					5	=>	$sub2,
					6	=>	$sub3,
			);
		}
		else {
			$this->playerList = NULL;
		}
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData()
    {
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
			
			switch ($this->platformID) {
				case 1:
					$userdata = array(
							'data' => array(
									'teamsystemPcTeamID' 		=> NULL,
									'teamsystemPcTeamPositionID' => NULL,
							)
					);
					break;
				case 2:
					$userdata = array(
							'data' => array(
									'teamsystemPs4TeamID' 			=> NULL,
									'teamsystemPs4TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 3:
					$userdata = array(
							'data' => array(
									'teamsystemPs3TeamID' 			=> NULL,
									'teamsystemPs3TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 4:
					$userdata = array(
							'data' => array(
									'teamsystemXb1TeamID' 			=> NULL,
									'teamsystemXb1TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 5:
					$userdata = array(
							'data' => array(
									'teamsystemXb360TeamID' 			=> NULL,
									'teamsystemXb360TeamPositionID' 	=> NULL,
							)
					);
					break;
			}
			$userAction = new UserAction(array($this->playerID), 'update', $userdata);
			$userAction->executeAction();
			
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
					'application' 	=> 'teamsystem',
					'id'			=> $this->teamID,
			)),WCF::getLanguage()->get('teamsystem.team.kick.successfulRedirect'), 10);
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
				'playername'		=> $this->player->getUsername(),
		));
	}
	
}