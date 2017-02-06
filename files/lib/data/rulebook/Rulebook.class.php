<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:17
 */

namespace tourneysystem\data\rulebook;

use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;

class Rulebook extends TOURNEYSYSTEMDatabaseObject {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'rulebook';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'rulebookID';
}