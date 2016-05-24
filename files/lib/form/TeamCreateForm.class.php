<?php
namespace teamsystem\form;

use teamsystem\util\TeamUtil;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\WCF;
use wcf\system\request\LinkHandler;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;
use wcf\data\user\UserAction;
use teamsystem\data\team\TeamAction;

/**
 * Shows the Form to create a new team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamCreateForm extends AbstractForm {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'teamsystem.header.menu.teams';
	
	/**
	 * @see    \wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;
	
	public 	$teamID = '';
	
	public	$platform = '';
	public 	$teamname = '';
	public 	$teamtag = '';

	public  $formData = array(
			'teamname' => '',
			'teamTag' => '',
			'leaderID' => '',
		);

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canCreateTeam")) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\form\AbstractForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		if (isset($_POST['teamname'])) {
			$this->formData['teamname'] = StringUtil::trim($_POST['teamname']);
		}
		if (isset($_POST['teamtag'])) {
			$this->formData['teamtag'] = StringUtil::trim($_POST['teamtag']);
		}
		$this->formData['leaderID'] =  WCF::getUser()->getUserID();
		$this->formData['leaderName'] = WCF::getUser()->getUsername();
	}
	
	/**
	 * @see	wcf\form\IForm::validate()
	*/
	public function validate() {
		parent::validate();

		if (isset($_POST['teamname'])) {
			$this->teamname = StringUtil::trim($_POST['teamname']);
		}
		if (isset($_POST['teamtag'])) {
			$this->teamtag = StringUtil::trim($_POST['teamtag']);
		}
		if (isset($_POST['platform'])) {
			$this->platform = StringUtil::trim($_POST['platform']);
		}
		
		$this->validateTeamname($this->teamname);
		$this->validateTeamtag($this->teamtag);
		$this->validateplatform($this->platform);
	} 
	
	/**
	 * Throws a UserInputException if the teamname is not unique or not valid.
	 * 
	 * @param	string		$teamname
	 */
	protected function validateTeamname($teamname) {
		if (empty($teamname)) {
			throw new UserInputException('teamname');
		}
		
		// check for forbidden chars (e.g. the ",")
		if (!TeamUtil::isValidTeamname($teamname)) {
			throw new UserInputException('teamname', 'notValid');
		}
		
		// Check if teamname exists already.
		if (!TeamUtil::isAvailableTeamname($teamname)) {
			throw new UserInputException('teamname', 'notUnique');
		}
	}
	
	/**
	 * Throws a UserInputException if the teamtag is not unique or not valid.
	 * 
	 * @param	string		$teamtag
	 */
	protected function validateTeamtag($teamtag) {
		if (empty($teamtag)) {
			throw new UserInputException('teamtag');
		}
		
		// check for forbidden chars (e.g. the ",")
		if (!TeamUtil::isValidTeamtag($teamtag)) {
			throw new UserInputException('teamtag', 'notValid');
		}
		
		// Check if teamtag exists already.
		if (!TeamUtil::isAvailableTeamtag($teamtag)) {
			throw new UserInputException('teamtag', 'notUnique');
		}
	}
	
	protected function validateplatform($platform) {
		if (empty($platform)) {
			throw new UserInputException('platform');
		}
		// check if user already has a  team for this platform
		if (!TeamUtil::isFreePlatformPlayer($platform, "leaderID", WCF::getUser()->userID)) {
			throw new UserInputException('platform', 'notUnique');
		}
	}
	
	/**
	 * @see \wcf\form\AbstractForm::save()
	 */
	public function save() {
		parent::save();
		$data = array(
		'data' => array(
			'teamName'		=> $this->formData['teamname'], 
			'teamTag'		=> strtoupper($this->formData['teamtag']), 
			'platformID'	=> $this->platform,
			'leaderID'		=> $this->formData['leaderID'],
			'contactID'		=> $this->formData['leaderID'],
			),
		);
		$action = new TeamAction(array(), 'create', $data);
		$action->executeAction();
		switch ($this->platform) {
			case 1:
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'teamsystemPcTeamID' 		=> $userTeamID,
								'teamsystemPcTeamPositionID' => 0,
						)
				);
				break;
			case 2:
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'teamsystemPs4TeamID' 			=> $userTeamID,
								'teamsystemPs4TeamPositionID' 	=> 0,
						)
				);
				break;
			case 3:
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'teamsystemPs3TeamID'		 => $userTeamID,
								'teamsystemPs3TeamPositionID' => 0,
						)
				);
				break;
			case 4:
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'teamsystemXb1TeamID'		 => $userTeamID,
								'teamsystemXb1TeamPositionID' => 0,
						)
				);
				break;
			case 5:
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'teamsystemXb360TeamID'			 => $userTeamID,
								'teamsystemXb360TeamPositionID'	 => 0,
						)
				);
				break;
		}
		$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
		$userAction->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
			'application' 	=> 'teamsystem',
			'id'			=> TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID),
		)),WCF::getLanguage()->get('teamsystem.team.create.successfulRedirect'), 10);				
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'formData' 	=> $this->formData,
			'teamname'	=> $this->teamname,
			'teamtag' 	=> $this->teamtag,
			'platform' 	=> $this->platform,
		));
	}

}
