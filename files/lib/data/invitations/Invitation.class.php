<?php

namespace tourneysystem\data\invitations;

use wcf\data\DatabaseObject;
use wcf\system\WCF;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;

class Invitation extends TOURNEYSYSTEMDatabaseObject {
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'invitations';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'invitationID';
}