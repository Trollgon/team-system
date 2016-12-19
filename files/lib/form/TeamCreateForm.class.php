<?php
namespace teamsystem\form;

use teamsystem\data\platform\PlatformList;
use teamsystem\util\TeamUtil;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
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
	
	public	$platformID = '';
    public  $platformArray = array();
	public 	$teamname = '';
	public 	$teamtag = '';

	public  $formData = array(
			'teamname' => '',
			'teamTag' => '',
			'leaderID' => '',
		);

    /**
     * @see \wcf\form\AbstractForm::readParameters()
     */
    public function readParameters(){
        parent::readParameters();
        $this->platformArray = new PlatformList();
        $this->platformArray->setObjectIDs(TeamUtil::getAllPlatforms());
        $this->platformArray->readObjects();
    }

    /**
	 * @see \wcf\form\AbstractForm::show()
	 */
	public function show() {
		if (!WCF::getSession()->getPermission("user.teamSystem.canCreateTeam")) {
			throw new PermissionDeniedException();
		}
		if (count(TeamUtil::getAllPlatforms()) == 0) {
            throw new IllegalLinkException();
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
	 * @see	\wcf\form\AbstractForm::validate()
	*/
	public function validate() {
		parent::validate();

		if (isset($_POST['teamname'])) {
			$this->teamname = StringUtil::trim($_POST['teamname']);
		}
		if (isset($_POST['teamtag'])) {
			$this->teamtag = StringUtil::trim($_POST['teamtag']);
		}
		if (isset($_POST['platformID'])) {
			$this->platformID = StringUtil::trim($_POST['platformID']);
		}
		
		$this->validateTeamname($this->teamname);
		$this->validateTeamtag($this->teamtag);
		$this->validateplatform($this->platformID);
	}

    /**
     * @param $teamname
     * @throws UserInputException
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
     * @param $teamtag
     * @throws UserInputException
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

    /**
     * @param $platformID
     * @throws UserInputException
     */
	protected function validateplatform($platformID) {
		if (empty($platformID)) {
			throw new UserInputException('platform');
		}
		// check if user already has a team for this platform
		if (!TeamUtil::isFreePlatformPlayer($platformID, WCF::getUser()->userID)) {
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
			'platformID'	=> $this->platformID,
			'leaderID'		=> $this->formData['leaderID'],
			'contactID'		=> $this->formData['leaderID'],
            'dummyTeam'		=> 0,
			),
		);
		$action = new TeamAction(array(), 'create', $data);
		$action->executeAction();
        $sql = "INSERT INTO teamsystem1_user_to_team_to_position_to_platform (userID, teamID, platformID, positionID)
                  VALUES (?, ?, ?, ?)";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array(WCF::getSession()->getUser()->getUserID(), TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID()), $this->platformID, 0));

		HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
			'application' 	=> 'teamsystem',
			'id'			=> TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->userID),
		)),WCF::getLanguage()->get('teamsystem.team.create.successfulRedirect'), 10);				
		exit;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
			'formData' 	    =>  $this->formData,
			'teamname'	    =>  $this->teamname,
			'teamtag' 	    =>  $this->teamtag,
			'platformID' 	=>  $this->platformID,
            'platformArray' =>  $this->platformArray,
		));
	}

}
