<?php
namespace teamsystem\data\team;
use wcf\data\DatabaseObjectList;
use wcf\system\WCF;

/**
 * Class TeamList
 * @package teamsystem\data\team
 */
class TeamList extends DatabaseObjectList {
	/**
	 * @see    \wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'teamsystem\data\team\Team';
}
