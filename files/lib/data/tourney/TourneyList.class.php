<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:30
 */

namespace tourneysystem\data\tourney;

use wcf\data\DatabaseObjectList;

class TourneyList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\tourney\Tourney';
}