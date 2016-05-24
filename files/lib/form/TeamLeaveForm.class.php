<?php
namespace teamsystem\form;

use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\system\request\LinkHandler;
use wcf\data\user\UserAction;
use teamsystem\data\team\Team;
use teamsystem\data\team\TeamAction;

/**
 * Shows the Form to leave a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */
class TeamLeaveForm extends AbstractForm {
	
	public $accept = false;
	
	public $platformID = 0;
	public $team = null;
	public $teamID = 0;
	public $playerID = 0;
	public $positionID = 0;
	
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
		$this->team = new Team($this->teamID);
		$this->platformID = $this->team->getPlatformID();
		$this->playerID = WCF::getUser()->getUserID();
		$this->positionID = $this->team->getPositionID($this->playerID, $this->platformID, $this->teamID);
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}
	

	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!$this->team->isTeamMember())
			throw new PermissionDeniedException();
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
							'player2Name'	=> NULL,
							),
						);
					break;
				case 2:
					$data = array(
						'data' => array(
							'player3ID'		=> NULL,
							'player3Name'	=> NULL,
							),
						);
					break;
				case 3:
					$data = array(
						'data' => array(
							'player4ID'		=> NULL,
							'player4Name'	=> NULL,
							),
						);
					break;
				case 4:
					$data = array(
						'data' => array(
							'sub1ID'	=> NULL,
							'sub1Name'	=> NULL,
							),
						);
					break;
				case 5:
					$data = array(
						'data' => array(
							'sub2ID'	=> NULL,
							'sub2Name'	=> NULL,
							),
						);
				case 6:
					$data = array(
						'data' => array(
							'sub3ID'	=> NULL,
							'sub3Name'	=> NULL,
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
			$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
			$userAction->executeAction();
			
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('TeamList', array(
					'application' 	=> 'teamsystem',
			)),WCF::getLanguage()->get('teamsystem.team.leave.successfulRedirect'), 10);
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
				'playerID'		=> $this->playerID,
				'positionID'	=> $this->positionID,
				'contact'		=> $this->team->getContactProfile(),
				'user'			=> $this->team->getContactProfile(),
		));
	}
	
}