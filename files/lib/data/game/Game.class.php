<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:12
 */

namespace tourneysystem\data\game;


use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

class Game extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'game';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'gameID';

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return $this->gameName;
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->gameID;
    }
}