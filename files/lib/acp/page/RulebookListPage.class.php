<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:29
 */

namespace tourneysystem\acp\page;

use wcf\page\SortablePage;
use wcf\system\WCF;

class RulebookListPage extends SortablePage {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.list';

    public $objectListClassName = 'tourneysystem\data\rulebook\RulebookList';

    public function initObjectList() {
        parent::initObjectList();

        if (!WCF::getSession()->getPermission('admin.tourneySystem.canEditAllRulebooks')) {
            $this->objectList->getConditionBuilder()->add('tourneysystem1_rulebook.creatorID = ?', array(WCF::getUser()->getUserID()));
        }
    }
}