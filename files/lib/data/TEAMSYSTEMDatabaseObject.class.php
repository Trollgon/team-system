<?php
namespace teamsystem\data;

use wcf\data\DatabaseObject;
use wcf\system\WCF;

/*--------------------------------------------------------------------------------------------------
File       : NEWSDatabaseObject.class.php
Description: News database object class
Copyright  : Olaf Braun © 2015
Author     : Olaf Braun
Last edit  : 01.03.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

abstract class TEAMSYSTEMDatabaseObject extends DatabaseObject {

	/**
	 * @see    \wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'teamsystem1_'.static:: $databaseTableName;
	}
}