<?php

namespace tourneysystem\data\team;

use tourneysystem\data\TEAMDatabaseObject;
use wcf\data\DatabaseObject;

class Team extends TEAMDatabaseObject {
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'teams';
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'teamID';
}