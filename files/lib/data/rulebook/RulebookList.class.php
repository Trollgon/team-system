<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:25
 */

namespace tourneysystem\data\rulebook;


use wcf\data\DatabaseObjectList;

class RulebookList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\rulebook\Rulebook';
}