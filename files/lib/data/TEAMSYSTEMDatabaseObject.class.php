<?php
namespace tourneysystem\data;

use wcf\data\DatabaseObject;
use wcf\system\WCF;

/**
 * Class TOURNEYSYSTEMDatabaseObject
 * @package tourneysystem\data
 */
abstract class TOURNEYSYSTEMDatabaseObject extends DatabaseObject {

	/**
	 * @see    \wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'tourneysystem1_'.static:: $databaseTableName;
	}
}