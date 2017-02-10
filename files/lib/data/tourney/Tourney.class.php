<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 17:49
 */

namespace tourneysystem\data\tourney;

use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

class Tourney extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'tourney';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'tourneyID';

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->tourneyID;
    }

    /**
     * Returns the title of the object.
     *
     * @return    string
     */
    public function getTitle() {
        return $this->tourneyName;
    }
}