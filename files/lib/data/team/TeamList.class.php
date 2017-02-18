<?php
namespace tourneysystem\data\team;
use wcf\data\DatabaseObjectList;

/**
 * Class TeamList
 * @package tourneysystem\data\team
 */
class TeamList extends DatabaseObjectList {
	/**
	 * @see    \wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'tourneysystem\data\team\Team';
}
