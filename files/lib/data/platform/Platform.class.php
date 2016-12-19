<?php
/**
 * Created by Trollgon.
 * Date: 14.12.2016
 * Time: 11:39
 */

namespace teamsystem\data\platform;


use teamsystem\data\TEAMSYSTEMDatabaseObject;

class Platform extends TEAMSYSTEMDatabaseObject {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'platforms';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'platformID';

    public function getPlatformName() {
        return $this->platformName;
    }
}