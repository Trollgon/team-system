<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 10:24
 */

namespace tourneysystem\acp\page;

use tourneysystem\data\rulebook\article\RulebookArticle;
use wcf\page\SortablePage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookRuleListPage extends SortablePage {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.list';

    public $objectListClassName = 'tourneysystem\data\rulebook\rule\RulebookRuleList';

    public $rulebookArticleID = 0;

    public $rulebookArticle = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['rulebookArticleID'])) {
            $this->rulebookArticleID = intval($_REQUEST['rulebookArticleID']);
        }
        $this->rulebookArticle = new RulebookArticle($this->rulebookArticleID);
        if (!$this->rulebookArticle->rulebookArticleID) {
            throw new IllegalLinkException();
        }
    }

    public function initObjectList() {
        parent::initObjectList();

        $this->objectList->getConditionBuilder()->add('articleID = ?', array($this->rulebookArticleID));
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'article'   =>  $this->rulebookArticle,
            'rulebook'  =>  $this->rulebookArticle->getRulebook(),
        ));
    }
}