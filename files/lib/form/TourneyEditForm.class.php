<?php
/**
 * Created by Trollgon.
 * Date: 13.02.2017
 * Time: 14:23
 */

namespace tourneysystem\form;

use tourneysystem\data\tourney\Tourney;
use tourneysystem\data\tourney\TourneyAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\DateUtil;
use wcf\util\HeaderUtil;

class TourneyEditForm extends TourneyCreateForm {
    /**
     * @var int
     */
    public $tourneyID = 0;

    /**
     * @var object
     */
    public $tourney = null;

    public $templateName = 'tourneyEdit';

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id']))
            $this->tourneyID = intval($_REQUEST['id']);
        $this->tourney = new Tourney($this->tourneyID);
        if (!$this->tourney->tourneyID) {
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
     * @see wcf\form\IForm::save()
     */
    public function save() {
        AbstractForm::save();

        $data = array(
            'data' => array(
                'platformID'  =>  $this->platformID,
                'gameID'  =>  $this->gameID,
                'gamemodeID'  => $this->gamemodeID,
                'tourneyName'   =>  $this->tourneyName,
                'participantType'   =>  1,
                'rulebookID'    =>  $this->rulebookID,
                'firstTourneyMode'  =>  1,
                'tourneyStartTime'    =>  $this->time->getTimestamp(),
                'tourneyStatus'   =>  $this->tourney->tourneyStatus,
                'minParticipants'   =>  $this->minParticipants,
                'maxParticipants' =>  $this->maxParticipants,
                'creatorID' =>  WCF::getUser()->getUserID(),
                'officialTourney'   =>  $this->officialTourney,
            ),
        );

        // update page
        $action = new TourneyAction(array($this->tourneyID), 'update', $data);
        $action->executeAction();

        $this->saved();

        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Tourney', array(
            'application' 	=> 'tourneysystem',
            'id'			=> $this->tourneyID,
        )),WCF::getLanguage()->get('tourneysystem.tourney.edit.successfulRedirect'), 10);
        exit;
    }

    /**
     * @see wcf\page\IPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyPage", $this->tourneyID, $this->tourney);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");

        $this->gameID = $this->tourney->gameID;
        $this->gamemodeID = $this->tourney->gamemodeID;
        $this->platformID = $this->tourney->platformID;
        $this->rulebookID = $this->tourney->rulebookID;
        $this->officialTourney = $this->tourney->officialTourney;
        $this->tourneyName = $this->tourney->tourneyName;
        $this->minParticipants = $this->tourney->minParticipants;
        $this->enableMaxParticipants = $this->tourney->enableMaxParticipants;
        $this->maxParticipants = $this->tourney->maxParticipants;
        $dateTime = DateUtil::getDateTimeByTimestamp($this->tourney->tourneyStartTime);
        $dateTime->setTimezone(WCF::getUser()->getTimeZone());
        $this->time = $dateTime->format('c');
    }

    /**
     * @see \wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        WCF::getTPL()->assign(array(
            'tourney' =>    $this->tourney,
        ));
    }
}