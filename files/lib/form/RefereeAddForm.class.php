<?php
/**
 * Created by Trollgon.
 * Date: 13.02.2017
 * Time: 16:32
 */

namespace tourneysystem\form;

use tourneysystem\data\tourney\Tourney;
use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\page\PageLocationManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;

class RefereeAddForm extends AbstractForm {

    public $tourney;
    public $tourneyID = 0;
    public $user;
    public $userID = 0;
    public $username = '';

    /**
     * @see \wcf\page\AbstractPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();
        if(isset($_REQUEST['tourneyID']))
            $this->tourneyID = intval($_REQUEST['tourneyID']);
        if($this->tourneyID == 0) {
            throw new IllegalLinkException();
        }
        $this->tourney = new Tourney($this->tourneyID);

        if($this->tourney->tourneyID == null || $this->tourney->tourneyID == 0) {
            throw new IllegalLinkException();
        }
    }

    /**
     * @see \wcf\form\AbstractForm::show()
     */
    public function show() {
        if (WCF::getUser()->getUserID() == 0) {
            throw new PermissionDeniedException();
        }
        if (!WCF::getSession()->getPermission("admin.tourneySystem.canCreateTourneys")) {
            throw new PermissionDeniedException();
        }
        if (!WCF::getSession()->getUser()->getUserID() == $this->tourney->creatorID) {
            throw new PermissionDeniedException();
        }
        parent::show();
    }

    /**
     * @see \wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();
        if (isset($_POST['username'])) {
            $this->username = StringUtil::trim($_POST['username']);
            $this->user = User::getUserByUsername($this->username);
            $this->userID = $this->user->getUserID();
        }
    }

    /**
     * @see	wcf\form\IForm::validate()
     */
    public function validate() {
        if (empty($this->username)) {
            throw new UserInputException('username');
        }

        //check if the user exists
        if (($this->user->getUserID() == 0)) {
            throw new UserInputException('username', 'notValid');
        }

        // check if the user is not already a referee for this tourney
        if ($this->tourney->isReferee($this->userID)) {
            throw new UserInputException('username', 'notUnique');
        }
    }

    /**
     * @see \wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();
        $this->tourney->addReferee($this->userID);
        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('RefereeAdd', array(
            'application' 	=> 'tourneysystem',
            'tourneyID'		=> $this->tourneyID,
        )),WCF::getLanguage()->get('tourneysystem.tourney.referee.add.successfulRedirect'), 10);
        exit;
    }

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyRefereeList");
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyPage", $this->tourneyID, $this->tourney);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }

    /**
     * @see \wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        $username = new User($this->userID);

        WCF::getTPL()->assign(array(
            'tourney'	=> $this->tourney,
            'username'  => $username,
        ));
    }
}