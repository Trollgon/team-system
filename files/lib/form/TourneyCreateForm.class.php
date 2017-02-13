<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 13:51
 */

namespace tourneysystem\form;

use tourneysystem\data\game\GameList;
use tourneysystem\data\gamemode\GamemodeList;
use tourneysystem\data\platform\PlatformList;
use tourneysystem\data\rulebook\RulebookList;
use tourneysystem\data\tourney\Tourney;
use tourneysystem\data\tourney\TourneyAction;
use tourneysystem\util\TourneyUtil;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\page\PageLocationManager;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;

class TourneyCreateForm extends AbstractForm {

    public $gameID = 0;
    public $gameList;
    public $gamemodeID = 0;
    public $gamemodeList;
    public $platformID = 0;
    public $platformList;
    public $rulebookID = null;
    public $tourneyName = '';
    public $minParticipants = 0;
    public $enableMaxParticipants = 0;
    public $maxParticipants = null;
    public $time;
    public $timeInput;
    public $officialTourney = 0;

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
        $this->platformList = new PlatformList();
        $this->platformList->readObjects();
        if (count($this->platformList) == 0) {
            throw new IllegalLinkException();
        }
        $this->gameList = new GameList();
        $this->gameList->readObjects();
        if (count($this->gameList) == 0) {
            throw new IllegalLinkException();
        }
        $this->gamemodeList = new GamemodeList();
        $this->gamemodeList->readObjects();
        if (count($this->gamemodeList) == 0) {
            throw new IllegalLinkException();
        }
        parent::show();
    }

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }

    /**
     * @see \wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();
        if (isset($_POST['gameID'])) {
            $this->gameID = StringUtil::trim($_POST['gameID']);
        }
        if (isset($_POST['gamemodeID'])) {
            $this->gamemodeID = StringUtil::trim($_POST['gamemodeID']);
        }
        if (isset($_POST['platformID'])) {
            $this->platformID = StringUtil::trim($_POST['platformID']);
        }
        if (isset($_POST['rulebookID'])) {
            $this->rulebookID = StringUtil::trim($_POST['rulebookID']);
        }
        if (isset($_POST['tourneyName'])) {
            $this->tourneyName = StringUtil::trim($_POST['tourneyName']);
        }
        if (isset($_POST['officialTourney'])) {
            $this->officialTourney = 1;
        }
        if (isset($_POST['minParticipants'])) {
            $this->minParticipants = StringUtil::trim($_POST['minParticipants']);
        }
        if (isset($_POST['enableMaxParticipants'])) {
            $this->enableMaxParticipants = 1;
            if (isset($_POST['maxParticipants'])) {
                $this->maxParticipants = StringUtil::trim($_POST['maxParticipants']);
            }
        }
        if (isset($_POST['time'])) {
            $this->timeInput = ($_POST['time']);
            $this->time = \DateTime::createFromFormat('Y-m-d\TH:i:sP', $this->timeInput);
        }
    }

    /**
     * @see	\wcf\form\AbstractForm::validate()
     */
    public function validate() {
        parent::validate();

        //check if empty
        if (empty($this->gameID)) {
            throw new UserInputException('game');
        }
        if (empty($this->gamemodeID)) {
            throw new UserInputException('gamemode');
        }
        if (empty($this->platformID)) {
            throw new UserInputException('platform');
        }
        if (empty($this->tourneyName)) {
            throw new UserInputException('tourneyName');
        }
        if (empty($this->minParticipants)) {
            throw new UserInputException('minParticipants');
        }
        if (empty($this->maxParticipants) && $this->enableMaxParticipants == 1) {
            throw new UserInputException('maxParticipants');
        }
        if (empty($this->time)) {
            throw new UserInputException('time');
        }
        if (!$this->time) {
            throw new UserInputException('time', 'invalid');
        }

        //check if valid
        if (intval($this->minParticipants) > intval($this->maxParticipants) && !empty($this->maxParticipants)) {
            throw new UserInputException('maxParticipants', 'tooHigh');
        }

        //check for forbidden chars (e.g. the ",")
        if (!TourneyUtil::isValidTourneyName($this->tourneyName)) {
            throw new UserInputException('tourneyName', 'notValid');
        }

        //check if name exists already.
        if (!TourneyUtil::isAvailableTourneyName($this->tourneyName)) {
            throw new UserInputException('tourneyName', 'notUnique');
        }
    }

    /**
     * @see \wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();
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
                'tourneyStatus'   =>  0,
                'minParticipants'   =>  $this->minParticipants,
                'maxParticipants' =>  $this->maxParticipants,
                'creatorID' =>  WCF::getUser()->getUserID(),
                'officialTourney'   =>  $this->officialTourney,
            ),
        );
        $action = new TourneyAction(array(), 'create', $data);
        $action->executeAction();

        $tourney = new Tourney(TourneyUtil::getTourneyIdByName($this->tourneyName));

        $sql = "INSERT INTO tourneysystem1_referee_to_tourney (userID, tourneyID)
                  VALUES (?, ?)";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array(WCF::getSession()->getUser()->getUserID(), $tourney->getID()));

        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Tourney', array(
            'application' 	=> 'tourneysystem',
            'id'			=> $tourney->getID(),
        )),WCF::getLanguage()->get('tourneysystem.tourney.create.successfulRedirect'), 10);
        exit;
    }

    /**
     * @see \wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        $rulebookArray = new RulebookList();
        $rulebookArray->readObjects();

        WCF::getTPL()->assign(array(
            'gameArray'             =>  $this->gameList,
            'gameID'                =>  $this->gameID,
            'gameModeArray'         =>  $this->gamemodeList,
            'gamemodeID'            =>  $this->gamemodeID,
            'platformArray'         =>  $this->platformList,
            'platformID'            =>  $this->platformID,
            'rulebookArray'         =>  $rulebookArray,
            'rulebookID'            =>  $this->rulebookID,
            'officialTourney'       =>  $this->officialTourney,
            'tourneyName'           =>  $this->tourneyName,
            'minParticipants'       =>  $this->minParticipants,
            'enableMaxParticipants' =>  $this->enableMaxParticipants,
            'maxParticipants'       =>  $this->maxParticipants,
            'time'                  =>  $this->time,
        ));
    }
}