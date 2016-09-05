<?php

namespace teamsystem\form;

use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\form\AbstractForm;
use teamsystem\data\team\avatar\TeamAvatarAction;
use teamsystem\data\team\TeamAction;
use teamsystem\data\team\Team;
use wcf\data\user\User;



/**

 * Shows the avatar edit form.

 * 

 * @author	Marcel Werk

 * @copyright	2001-2015 WoltLab GmbH

 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>

 * @package	com.woltlab.wcf

 * @subpackage	form

 * @category	Community Framework

 */

class TeamAvatarEditForm extends AbstractForm {

	/**

	 * @see	\wcf\page\AbstractPage::$enableTracking

	 */

	public $enableTracking = true;

	

	/**

	 * @see	\wcf\page\AbstractPage::$loginRequired

	 */

	public $loginRequired = true;

	

	/**

	 * @see	\wcf\page\AbstractPage::$templateName

	 */

	public $templateName = 'teamAvatarEdit';
	
	public 	$team = null;
	public 	$teamID = '';
	public	$platform = '';
	public 	$contact = 0;
	public 	$contactID = 0;
	public	$playerList = null;
	public	$userOption = '';

	

	/**

	 * avatar type

	 * @var	string

	 */

	public $avatarType = 'none';

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
			$this->description = $this->team->teamDescription;
			if($this->team->teamID == null || $this->team->teamID == 0) {
				throw new IllegalLinkException();
			}
	}

	/**

	 * @see	\wcf\form\IForm::readFormParameters()

	 */

	public function readFormParameters() {

		parent::readFormParameters();

		

		if (isset($_POST['avatarType'])) $this->avatarType = $_POST['avatarType'];

	}

	

	/**

	 * @see	\wcf\form\IForm::validate()

	 */

	public function validate() {

		parent::validate();
		

		if ($this->avatarType != 'custom') $this->avatarType = 'none';

		

		if ($this->avatarType == 'custom') {

				if (!$this->team->avatarID) {

					throw new UserInputException('custom');

				}

		}

	}

	

	/**

	 * @see	\wcf\form\IForm::save()

	 */

	public function save() {

		parent::save();

		

		if ($this->avatarType != 'custom') {

			// delete custom avatar

			if ($this->team->avatarID) {

				$action = new TeamAvatarAction(array($this->team->avatarID), 'delete');

				$action->executeAction();

			}

		}

		

		// update user

		if ($this->avatarType == 'none') {

				$data = array(
						'data' => array(
								'avatarID' => null,
						),

				);


		}

		$this->objectAction = new TeamAction(array($this->teamID), 'update', $data);

		$this->objectAction->executeAction();

		$this->team = new Team($this->teamID);

		

		$this->saved();

		WCF::getTPL()->assign('success', true);

	}

	

	/**

	 * @see	\wcf\page\IPage::readData()

	 */

	public function readData() {

		parent::readData();

		

		if (empty($_POST)) {

			if ($this->team->avatarID) $this->avatarType = 'custom';

		}

	}

	

	/**

	 * @see	\wcf\page\IPage::assignVariables()

	 */

	public function assignVariables() {

		parent::assignVariables();

		

		WCF::getTPL()->assign(array(

			'avatarType'	=> $this->avatarType,
			'team'			=> $this->team,
			'teamID'		=> $this->teamID,
			'platform' 		=> $this->platform,
			'contactForm'	=> $this->team->getPositionID($this->team->contactID, $this->team->getPlatformID(), $this->teamID),
			'contact'		=> $this->team->getContactProfile(),
			'user'			=> $this->team->getContactProfile(),
			'playerList'	=> $this->playerList,
			'userOption'	=> $this->userOption,

		));

	}

	

	/**

	 * @see	\wcf\page\IPage::show()

	 */

	public function show() {
		if(!$this->team->isTeamLeader() || !WCF::getSession()->getPermission("mod.teamSystem.canEditTeams"))
			throw new PermissionDeniedException();
		parent::show();

	}

}

