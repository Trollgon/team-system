<?php
/**
 * Created by Trollgon.
 * Date: 13.02.2017
 * Time: 17:35
 */

namespace tourneysystem\page;

use tourneysystem\data\rulebook\Rulebook;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookPage extends AbstractPage {

    public $rulebook;
    public $rulebookID = 0;

    /**
     * @see \wcf\page\AbstractPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();
        if (isset($_REQUEST['id']))
            $this->rulebookID = intval($_REQUEST['id']);
        if ($this->rulebookID == 0) {
            throw new IllegalLinkException();
        }
        $this->rulebook = new Rulebook($this->rulebookID);
    }

    /**
     * @see \wcf\page\AbstractPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        WCF::getTPL()->assign(array(
            'rulebook'  =>  $this->rulebook,
        ));
    }
}