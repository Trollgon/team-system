<?php
/**
 * Created by Trollgon.
 * Date: 12.09.2016
 * Time: 14:16
 */

namespace tourneysystem\form;

use tourneysystem\data\platform\Platform;
use tourneysystem\data\team\avatar\TeamAvatarAction;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamAction;
use wcf\data\user\UserProfileList;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use wcf\form\AbstractForm;


class TeamAvatarEditForm extends AbstractForm {

    /**
     * @see	\wcf\page\AbstractPage::$templateName
     */
    public $templateName = 'teamAvatarEdit';

    public $teamID = '';
    public $team = '';
    public $platformID = '';
    public $contact = 0;
    public $contactID = 0;
    public $playerList = null;
    public $userOption = '';
    public $description = '';

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
     * @see	\wcf\page\IPage::show()
     */
    public function show() {
        parent::show();
        if(!$this->team->isTeamLeader()) {
            if (!WCF::getSession()->getPermission("mod.tourneySystem.canEditTeams")) {
                throw new PermissionDeniedException();
            }
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
        if ($this->avatarType != 'custom') {
            $this->avatarType = 'none';
        }
        elseif (!$this->team->avatarID) {
            throw new UserInputException('custom');
        }
    }

    /**
     * @see	\wcf\form\IForm::save()
     */
    public function save() {
        parent::save();
        if ($this->avatarType != 'custom') {

            // delete custom avatar
            if ($this->teamID) {
                $action = new TeamAvatarAction(array($this->team->avatarID), 'delete');
                $action->executeAction();
            }
        }

        if ($this->avatarType == 'none') {
                $data = array(
                    'avatarID' => null,
                );
        }
        else {
            $data = array();
        }

        /** @var  $data */
        $this->objectAction = new TeamAction(array($this->team), 'update', array(
            'data' => array_merge($this->additionalFields, $data),
        ));

        $this->objectAction->executeAction();

        $this->saved();

        WCF::getTPL()->assign('success', true);
    }

    /**
     * @see	\wcf\page\IPage::readData()
     */
    public function readData() {
        parent::readData();
        PageLocationManager::getInstance()->addParentLocation('de.trollgon.tourneysystem.TeamPage', $this->teamID, $this->team);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TeamList");

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
            'avatarType'    => $this->avatarType,
            'team'			=> $this->team,
			'teamID'		=> $this->teamID,
			'platform' 		=> $this->platformID,
			'contactForm'	=> $this->team->getPositionID($this->team->contactID, $this->team->getPlatformID(), $this->teamID),
			'contact'		=> $this->team->getContactProfile(),
			'user'			=> $this->team->getContactProfile(),
			'playerList'	=> $this->playerList,
			'userOption'	=> $this->userOption,
        ));
    }
}