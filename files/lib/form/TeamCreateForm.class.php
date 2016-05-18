<?php
namespace tourneysystem\form;

use tourneysystem\util\TeamUtil;
use tourneysystem\data\team\PcTeamAction;
use tourneysystem\data\team\Ps4TeamAction;
use tourneysystem\data\team\Ps3TeamAction;
use tourneysystem\data\team\Xb1TeamAction;
use tourneysystem\data\team\Xb360TeamAction;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\WCF;
use wcf\system\request\LinkHandler;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;
use wcf\data\user\UserAction;

/**
 * Shows the Form to create a new team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamCreateForm extends AbstractForm {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'tourneysystem.header.menu.teams';
	
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
			'leaderName' => ''
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
			'leaderID'		=> $this->formData['leaderID'],
			'leaderName'	=> $this->formData['leaderName'],
			),
		);
		switch ($this->platform) {
			case 1:
				$action = new PcTeamAction(array(), 'create', $data);
				$action->executeAction();
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'tourneysystemPcTeamID' => $userTeamID,
						)
				);
				break;
			case 2:
				$action = new Ps4TeamAction(array(), 'create', $data);
				$action->executeAction();
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'tourneysystemPs4TeamID' => $userTeamID,
						)
				);
				break;
			case 3:
				$action = new Ps3TeamAction(array(), 'create', $data);
				$action->executeAction();
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'tourneysystemPs3TeamID' => $userTeamID,
						)
				);
				break;
			case 4:
				$action = new Xb1TeamAction(array(), 'create', $data);
				$action->executeAction();
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'tourneysystemXb1TeamID' => $userTeamID,
						)
				);
				break;
			case 5:
				$action = new Xb360TeamAction(array(), 'create', $data);
				$action->executeAction();
				$userTeamID = TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID);
				$userdata = array(
						'data' => array(
								'tourneysystemXb360TeamID' => $userTeamID,
						)
				);
				break;
		}
		$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
		$userAction->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
			'application' 	=> 'tourneysystem',
			'teamID'		=> TeamUtil::getPlayersTeamID($this->platform, WCF::getUser()->userID),
			'platformID'	=> $this->platform,
		)),WCF::getLanguage()->get('tourneysystem.team.add.successfulRedirect'), 10);				
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'formData' 	=> $this->formData,
			'teamname'	=> $this->teamname,
			'teamtag' 	=> $this->teamtag,
			'platform' 	=> $this->platform
		));
	}

}
