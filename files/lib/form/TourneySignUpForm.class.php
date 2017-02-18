<?php
/**
 * Created by Trollgon.
 * Date: 15.09.2016
 * Time: 23:25
 */
namespace tourneysystem\form;
use tourneysystem\data\team\Team;
use tourneysystem\util\TeamInvitationUtil;
use tourneysystem\util\TeamUtil;
use tourneysystem\data\tourney\Tourney;
use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
class TourneySignUpForm extends AbstractForm {

    public $accept = '';
    public $missingContactInfo = false;
    public $platform = '';
    public $platformID = '';
    public $team = null;
    public $teamID = null;
    public $tourney = null;
    public $tourneyID = 0;

    /**
     * @see \wcf\page\AbstractPage::readParameters()
     * @throws IllegalLinkException
     */
    public function readParameters() {
        parent::readParameters();
        if(isset($_REQUEST['tourneyID']))
            $this->tourneyID = intval($_REQUEST['tourneyID']);
        if($this->tourneyID == 0) {
            throw new IllegalLinkException();
        }
        $this->tourney = new Tourney($this->tourneyID);
        $this->platform = $this->tourney->getPlatform();
        $this->platformID = $this->platform->getID();
        $this->teamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getUser()->getUserID());
        $this->team = new Team($this->teamID);

        $userOption = $this->platform->getPlatformUserOption();
        $userOptionName = $userOption->optionName;

        // checking if players set their gamer tags

        $leader = new User($this->team->leaderID);
        if ($leader->getUserOption($userOptionName) == NULL) {
            $this->missingContactInfo = true;
        }

        if ($this->team->player2ID != NULL) {
            $player2 = new User($this->team->player2ID);
            if ($player2->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->player3ID != NULL) {
            $player3 = new User($this->team->player3ID);
            if ($player3->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->player4ID != NULL) {
            $player4 = new User($this->team->player4ID);
            if ($player4->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub1ID != NULL) {
            $sub1 = new User($this->team->sub1ID);
            if ($sub1->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub2ID != NULL) {
            $sub2 = new User($this->team->sub2ID);
            if ($sub2->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }

        if ($this->team->sub3ID != NULL) {
            $sub3 = new User($this->team->sub3ID);
            if ($sub3->getUserOption($userOptionName) == NULL) {
                $this->missingContactInfo = true;
            }
        }
    }

    /**
     * @see	\wcf\page\IPage::show()
     */
    public function show() {
        if (!$this->tourney->userCanSignUp(WCF::getSession()->getUser()->getUserID())) {
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
        $sql = "INSERT INTO tourneysystem1_sign_up (tourneyID, participantID)
                  VALUES (?, ?)";
        $statement = WCF::getDB()->prepareStatement($sql);
        if (TeamInvitationUtil::isEmptyPosition($this->teamID, 1) == false && $this->missingContactInfo == false) {
            if ($this->tourney->participantType == 1) {
                $statement->execute(array($this->tourneyID, TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID())));
            }

            HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Tourney', array(
                'application'         =>  'tourneysystem',
                'id'                  =>  $this->tourneyID,
            )), WCF::getLanguage()->get('tourneysystem.tourney.signUp.successfulRedirect'), 10);
        }
        else {
            throw new UserInputException();
        }
        exit;
    }
    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        $memberMissing = TeamInvitationUtil::isEmptyPosition($this->teamID, 1);
        $subMissing = TeamUtil::hasMissingSub($this->teamID);

        WCF::getTPL()->assign(array(
            'memberMissing'				=>  $memberMissing,
            'subMissing'				=>  $subMissing,
            'juryArray'                 =>  $this->tourney->getReferees(),
            'missingContactInfo'	    =>  $this->missingContactInfo,
            'platform'                  =>  $this->platform,
            'team'                      =>  $this->team,
            'tourney'                   =>  $this->tourney,
            'tourneyID'                 =>  $this->tourneyID,
        ));
    }
}