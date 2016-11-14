<?php
/**
 * Created by Trollgon.
 * Date: 12.09.2016
 * Time: 14:16
 */

namespace teamsystem\form;

use teamsystem\data\team\avatar\TeamAvatarAction;
use teamsystem\data\team\Team;
use teamsystem\data\team\TeamAction;
use wcf\data\user\User;
use wcf\data\user\UserProfileList;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\form\AbstractForm;


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

        // checking if players set their gamertags

        $leader = new User($this->team->leaderID);
        if ($leader->getUserOption($this->userOption) == NULL && $this->team->leaderID == WCF::getUser()->getUserID()) {
            $this->missingContactInfo = true;
            $this->playerMissingContactInfo = true;
        }

        if ($this->team->player2ID != NULL) {
            $player2 = new User($this->team->player2ID);
            if ($player2->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->player3ID != NULL) {
            $player3 = new User($this->team->player3ID);
            if ($player3->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->player4ID != NULL) {
            $player4 = new User($this->team->player4ID);
            if ($player4->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub1ID != NULL) {
            $sub1 = new User($this->team->sub1ID);
            if ($sub1->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub2ID != NULL) {
            $sub2 = new User($this->team->sub2ID);
            if ($sub2->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub3ID != NULL) {
            $sub3 = new User($this->team->sub3ID);
            if ($sub3->getUserOption($this->userOption) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        $this->playerList = new UserProfileList();
        switch ($this->platformID) {
            case 1:
                $this->playerList->getConditionBuilder()->add("teamsystemPcTeamID = ?", array($this->teamID));
                break;
            case 2:
                $this->playerList->getConditionBuilder()->add("teamsystemPs4TeamID = ?", array($this->teamID));
                break;
            case 3:
                $this->playerList->getConditionBuilder()->add("teamsystemPs3TeamID = ?", array($this->teamID));
                break;
            case 4:
                $this->playerList->getConditionBuilder()->add("teamsystemXb1TeamID = ?", array($this->teamID));
                break;
            case 5:
                $this->playerList->getConditionBuilder()->add("teamsystemXb360TeamID = ?", array($this->teamID));
                break;
        }

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
        if(!$this->team->isTeamLeader() || !WCF::getSession()->getPermission("mod.teamSystem.canEditTeams"))
            throw new PermissionDeniedException();
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




        if ($this->avatarType != 'custom' && $this->avatarType != 'gravatar') $this->avatarType = 'none';



        switch ($this->avatarType) {

            case 'custom':

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

        WCF::getBreadcrumbs()->add(new Breadcrumb($this->team->teamName, LinkHandler::getInstance()->getLink('Team', array(
            'application' 	=> 'teamsystem',
            'id'            => $this->teamID
        ))));

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

