<?php
/**
 * Created by Trollgon.
 * Date: 19.09.2016
 * Time: 18:47
 */
namespace tourneysystem\form;
use tourneysystem\data\team\Team;
use tourneysystem\util\TeamUtil;
use tourneysystem\data\tourney\Tourney;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;

class TourneySignOffForm extends AbstractForm {

    public $accept = '';
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
        $this->teamID = TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID());
        $this->team = new Team($this->teamID);
    }

    /**
     * @see	\wcf\page\IPage::show()
     */
    public function show() {
        if (!$this->tourney->userCanSignOff(WCF::getSession()->getUser()->getUserID())) {
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
        $sql = "DELETE FROM tourneysystem1_sign_up 
                  WHERE tourneyID = ? AND participantID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        if ($this->tourney->participantType == 1) {
            $statement->execute(array($this->tourneyID, TeamUtil::getPlayersTeamID($this->platformID, WCF::getSession()->getUser()->getUserID())));
        }
        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Tourney', array(
            'application'         =>  'tourneysystem',
            'id'                  =>  $this->tourneyID,
        )), WCF::getLanguage()->get('tourneysystem.tourney.signOff.successfulRedirect'), 10);
        exit;
    }

    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'juryArray'             =>  $this->tourney->getReferees(),
            'platform'              =>  $this->platform,
            'team'                  =>  $this->team,
            'tourney'               =>  $this->tourney,
            'tourneyID'             =>  $this->tourneyID,
        ));
    }
}