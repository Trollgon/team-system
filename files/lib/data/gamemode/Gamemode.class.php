<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:15
 */

namespace tourneysystem\data\gamemode;


use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

class Gamemode extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'gamemode';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'gamemodeID';

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return $this->gamemodeName;
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->gamemodeID;
    }
}