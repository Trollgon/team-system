<?php

namespace tourneysystem\data\team;

use tourneysystem\data\TEAMDatabaseObject;
use wcf\data\DatabaseObject;

class Xb1Team extends TEAMDatabaseObject {
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'teams_xb1';
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'teamID';
}