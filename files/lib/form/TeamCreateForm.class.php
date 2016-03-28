<?php
namespace tourneysystem\form;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamAction;
use tourneysystem\data\team\TeamEditor;
use tourneysystem\util\TeamUtil;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\request\LinkHandler;
use wcf\system\exception\UserInputException;

/**
 * Shows the index page.
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
	
	public	$platform = '';
	public 	$teamname = '';
	public 	$teamtag = '';

	public  $formData = array(
			'teamname' => '',
			'teamTag' => '',
			'leaderID' => '',
			'platform' => '',
		);

	public function readFormParameters() {
		parent::readFormParameters();
		if (isset($_POST['teamname'])) {
			$this->formData['teamname'] = StringUtil::trim($_POST['teamname']);
		}
		if (isset($_POST['teamtag'])) {
			$this->formData['teamtag'] = StringUtil::trim($_POST['teamtag']);
		}
		$this->formData['leaderID'] =  WCF::getUser()->userID;
		$this->formData['platform'] = StringUtil::trim($_POST['platform']);
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
		$this->validateplatform($this->platform, WCF::getUser()->userID);

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
	
	protected function validateplatform($platform, $userID) {
		if (empty($platform)) {
			throw new UserInputException('platform');
		}
		// check if user already has a  team for this platform
		if (!TeamUtil::isFreePlatformPlayer($platform, $userID)) {
			throw new UserInputException('teamtag', 'notUnique');
		}
	}
	
	public function save() {
		parent::save();
		$data = array(
		'data' => array(
			'teamName'		=> $this->formData['teamname'], 
			'teamTag'		=> $this->formData['teamtag'], 
			'leaderID'		=> $this->formData['leaderID'],
			'platform'	=> $this->formData['platform'],
			
			),
		);
		$action = new TeamAction(array(), 'create', $data);
		$action->executeAction();
		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamsList', array(
			'application' => 'tourneysystem'
		)),WCF::getLanguage()->get('tourneysystem.team.add.successfulRedirect'), 10);				
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'formData' => $this->formData,
			'teamname' => $this->teamname,
			'teamtag' => $this->teamtag,
			'platform' => $this->platform
		));
	}

}
