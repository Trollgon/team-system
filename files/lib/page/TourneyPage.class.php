<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:57
 */

namespace tourneysystem\page;

use tourneysystem\data\rulebook\Rulebook;
use tourneysystem\data\team\TeamList;
use tourneysystem\data\tourney\Tourney;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;

class TourneyPage extends AbstractPage {

    public $rulebook;
    public $tourney;
    public $tourneyID = 0;

    /**
     * @see \wcf\page\AbstractPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();
        if (isset($_REQUEST['id']))
            $this->tourneyID = intval($_REQUEST['id']);
        if ($this->tourneyID == 0) {
            throw new IllegalLinkException();
        }
        $this->tourney = new Tourney($this->tourneyID);

        if ($this->tourney->rulebookID != null) {
            $this->rulebook = new Rulebook($this->tourney->rulebookID);
        }
    }

    /**
     * @see \wcf\page\AbstractPage::show()
     */
    public function show() {
        if ($this->tourney->getTourneyStatusID() == 0 && !$this->tourney->isReferee(WCF::getUser()->getUserID())) {
            throw new PermissionDeniedException();
        }

        parent::show();
    }

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }

    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        $signUp = $this->tourney->getSignUp();

        WCF::getTPL()->assign(array(
            'canSignUp' =>  $this->tourney->userCanSignUp(WCF::getUser()->getUserID()),
            'canSignOff'    =>  $this->tourney->userCanSignOff(WCF::getUser()->getUserID()),
            'juryArray' =>  $this->tourney->getReferees(),
            'rulebook'  =>  $this->rulebook,
            'signUp'    =>  $signUp,
            'tourney'   =>  $this->tourney,
        ));
    }
}