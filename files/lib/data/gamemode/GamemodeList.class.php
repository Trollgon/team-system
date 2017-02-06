<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:25
 */

namespace tourneysystem\data\gamemode;

use wcf\data\DatabaseObjectList;

class GamemodeList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\gamemode\Gamemode';
}