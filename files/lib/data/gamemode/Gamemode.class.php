<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:15
 */

namespace tourneysystem\data\gamemode;


use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;

class Gamemode extends TOURNEYSYSTEMDatabaseObject {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'gamemode';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'gamemodeID';
}