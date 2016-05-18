<?php
namespace tourneysystem\form;

use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use tourneysystem\data\team\PcTeam;
use tourneysystem\data\team\Ps4Team;
use tourneysystem\data\team\Ps3Team;
use tourneysystem\data\team\Xb1Team;
use tourneysystem\data\team\Xb360Team;
use tourneysystem\data\team\PcTeamAction;
use tourneysystem\data\team\Ps4TeamAction;
use tourneysystem\data\team\Ps3TeamAction;
use tourneysystem\data\team\Xb1TeamAction;
use tourneysystem\data\team\Xb360TeamAction;
use wcf\system\request\LinkHandler;
use wcf\data\user\UserAction;

/**
 * Shows the Form to leave a team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
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
	public $activeMenuItem = 'tourneysystem.header.menu.teams';
	
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
		if(isset($_REQUEST['platformID']))
			$this->platformID = intval($_REQUEST['platformID']);
		if($this->teamID == 0) {
			throw new IllegalLinkException();
		}
		if($this->platformID == 0) {
			throw new IllegalLinkException();
		}
		switch ($this->platformID) {
			case 1:
				$this->team = new PcTeam($this->teamID);
				break;
			case 2:
				$this->team = new Ps4Team($this->teamID);
				break;
			case 3:
				$this->team = new Ps3Team($this->teamID);
				break;
			case 4:
				$this->team = new Xb1Team($this->teamID);
				break;
			case 5:
				$this->team = new Xb360Team($this->teamID);
				break;
			}
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
			
			switch ($this->platformID) {
				case 1:
					$action = new PcTeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userdata = array(
							'data' => array(
									'tourneysystemPcTeamID' 		=> NULL,
									'tourneysystemPcTeamPositionID' => NULL,
							)
					);
					break;
				case 2:
					$action = new Ps4TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userdata = array(
							'data' => array(
									'tourneysystemPs4TeamID' 			=> NULL,
									'tourneysystemPs4TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 3:
					$action = new Ps3TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userdata = array(
							'data' => array(
									'tourneysystemPs3TeamID' 			=> NULL,
									'tourneysystemPs3TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 4:
					$action = new Xb1TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userdata = array(
							'data' => array(
									'tourneysystemXb1TeamID' 			=> NULL,
									'tourneysystemXb1TeamPositionID' 	=> NULL,
							)
					);
					break;
				case 5:
					$action = new Xb360TeamAction(array($this->teamID), 'update', $data);
					$action->executeAction();
					$userdata = array(
							'data' => array(
									'tourneysystemXb360TeamID' 			=> NULL,
									'tourneysystemXb360TeamPositionID' 	=> NULL,
							)
					);
					break;
			}
			$userAction = new UserAction(array(WCF::getUser()->getUserID()), 'update', $userdata);
			$userAction->executeAction();
			
			
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Teams', array(
					'application' 	=> 'tourneysystem',
			)),WCF::getLanguage()->get('tourneysystem.team.leave.successfulRedirect'), 10);
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
				'platformID'	=> $this->platformID,
				'playerID'		=> $this->playerID,
				'positionID'	=> $this->positionID,
		));
	}
	
}