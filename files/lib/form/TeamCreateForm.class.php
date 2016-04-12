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
	
	public function save() {
		parent::save();
		$data = array(
		'data' => array(
			'teamName'		=> $this->formData['teamname'], 
			'teamTag'		=> strtoupper($this->formData['teamtag']), 
			'leaderID'		=> $this->formData['leaderID'],
			),
		);
		switch ($this->platform) {
			case 1:
				$action = new PcTeamAction(array(), 'create', $data);
				break;
			case 2:
				$action = new Ps4TeamAction(array(), 'create', $data);
				break;
			case 3:
				$action = new Ps3TeamAction(array(), 'create', $data);
				break;
			case 4:
				$action = new Xb1TeamAction(array(), 'create', $data);
				break;
			case 5:
				$action = new Xb360TeamAction(array(), 'create', $data);
				break;
		}
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
