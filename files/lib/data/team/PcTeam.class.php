<?php

namespace tourneysystem\data\team;

use tourneysystem\data\TEAMDatabaseObject;
use wcf\data\DatabaseObject;
use wcf\system\WCF;

class PcTeam extends TEAMDatabaseObject {
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'teams_pc';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'teamID';
}