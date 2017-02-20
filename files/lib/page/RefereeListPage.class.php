<?php
/**
 * Created by Trollgon.
 * Date: 13.02.2017
 * Time: 16:04
 */

namespace tourneysystem\page;

use tourneysystem\data\tourney\Tourney;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;

class RefereeListPage extends AbstractPage  {

    public $refereeList;
    public $tourney = null;
    public $tourneyID = 0;

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

        $this->refereeList = $this->tourney->getReferees();

        if($this->tourney->tourneyID == null || $this->tourney->tourneyID == 0) {
            throw new IllegalLinkException();
        }
    }

    /**
     * @see \wcf\page\AbstractPage::show()
     */
    public function show() {
        if(!WCF::getSession()->getPermission("admin.tourneySystem.canCreateTourneys")) {
            throw new PermissionDeniedException();
        }
        if(!WCF::getUser()->getUserID() == $this->tourney->creatorID) {
            throw new PermissionDeniedException();
        }

        parent::show();
    }

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyPage", $this->tourneyID, $this->tourney);
        PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TourneyList");
    }

    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */

    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'tourney'       =>  $this->tourney,
            'refereeList'   =>  $this->refereeList,
            ));
    }

}