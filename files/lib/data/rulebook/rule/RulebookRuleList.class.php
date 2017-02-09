<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:38
 */

namespace tourneysystem\data\rulebook\rule;

use wcf\data\DatabaseObjectList;

class RulebookRuleList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\rulebook\rule\RulebookRule';
}