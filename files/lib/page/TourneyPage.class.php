<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:57
 */

namespace tourneysystem\page;

use tourneysystem\data\tourney\Tourney;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class TourneyPage extends AbstractPage {

    public $tourney = null;
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
    }

    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        WCF::getTPL()->assign(array(
            'tourney'   =>  $this->tourney,
        ));
    }
}