<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:24
 */

namespace tourneysystem\data\game;

use wcf\data\DatabaseObjectList;

class GameList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\game\Game';
}