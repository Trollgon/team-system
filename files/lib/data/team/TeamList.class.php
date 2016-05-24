<?php
namespace teamsystem\data\team;
use wcf\data\DatabaseObjectList;
use wcf\system\WCF;

/*--------------------------------------------------------------------------------------------------
File       : NewsList.class.php
Description: News object list class
Copyright  : Olaf Braun © 2015
Author     : Olaf Braun
Last edit  : 01.03.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class TeamList extends DatabaseObjectList {
	/**
	 * @see    \wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'teamsystem\data\team\Team';
}
