<?php
namespace tourneysystem\data\invitation;
use wcf\data\DatabaseObjectList;

/**
 * Class InvitationList
 * @package tourneysystem\data\invitation
 */
class InvitationList extends DatabaseObjectList {
	/**
	 * @see    \wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'tourneysystem\data\invitation\Invitation';
}
