<?php
namespace tourneysystem\data\invitations;
use wcf\data\DatabaseObjectList;

/**
 * Class InvitationList
 * @package tourneysystem\data\invitations
 */
class InvitationList extends DatabaseObjectList {
	/**
	 * @see    \wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'tourneysystem\data\invitations\Invitation';
}
