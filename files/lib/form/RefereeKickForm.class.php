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
use wcf\system\page\PageLocationManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;

class RefereeKickForm extends AbstractForm {

    public $accept = false;
    public $tourney;
    public $tourneyID= 0;
    public $user;
    public $userID = 0;

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

        if(isset($_REQUEST['userID']))
            $this->userID = intval($_REQUEST['userID']);
        if($this->userID == 0) {
            throw new IllegalLinkException();
        }
        $this->user = new User($this->userID);

        if($this->tourney->tourneyID == null || $this->tourney->tourneyID == 0) {
            throw new IllegalLinkException();
        }
        if($this->user->userID == null || $this->user->userID == 0) {
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

        if (isset($_POST['accept'])) {
            $this->accept = true;
        }
    }

    /**
     * @see \wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();
        $this->tourney->kickReferee($this->userID);
        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('RefereeList', array(
            'application' 	=> 'tourneysystem',
            'tourneyID'		=> $this->tourneyID,
        )),WCF::getLanguage()->get('tourneysystem.tourney.referee.kick.successfulRedirect'), 10);
        exit;
    }

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.RefereeList");
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyPage", $this->tourneyID, $this->tourney);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }

    /**
     * @see \wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'tourney'	=>  $this->tourney,
            'userID'    =>  $this->userID
        ));
    }
}