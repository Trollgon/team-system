<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 18:11
 */

namespace tourneysystem\acp\page;

use tourneysystem\data\rulebook\Rulebook;
use wcf\page\SortablePage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookArticleListPage extends SortablePage  {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.list';

    public $objectListClassName = 'tourneysystem\data\rulebook\article\RulebookArticleList';

    public $rulebookID = 0;

    public $rulebook = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['rulebookID']))
            $this->rulebookID = intval($_REQUEST['rulebookID']);
        $this->rulebook = new Rulebook($this->rulebookID);
        if (!$this->rulebook->rulebookID) {
            throw new IllegalLinkException();
        }
    }

    public function initObjectList() {
        parent::initObjectList();

        $this->objectList->getConditionBuilder()->add('rulebookID = ?', array($this->rulebookID));
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'rulebook' => $this->rulebook
        ));
    }
}