<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:28
 */

namespace tourneysystem\data\tourney;

use wcf\data\AbstractDatabaseObjectAction;

class TourneyAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\tourney\TourneyEditor';
}