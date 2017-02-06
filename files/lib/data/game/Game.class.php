<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:12
 */

namespace tourneysystem\data\game;


use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;

class Game extends TOURNEYSYSTEMDatabaseObject {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'game';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'gameID';
}