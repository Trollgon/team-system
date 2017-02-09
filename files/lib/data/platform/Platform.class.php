<?php
/**
 * Created by Trollgon.
 * Date: 14.12.2016
 * Time: 11:39
 */

namespace tourneysystem\data\platform;

use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\data\user\option\UserOption;
use wcf\system\request\IRouteController;

class Platform extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'platform';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'platformID';

    /**
     * @return string
     */
    public function getPlatformName() {
        return $this->platformName;
    }

    /**
     * @return UserOption
     */
    public function getPlatformUserOption() {
        $option = new UserOption($this->optionID);
        return $option;
    }

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return $this->platformName;
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->platformID;
    }
}