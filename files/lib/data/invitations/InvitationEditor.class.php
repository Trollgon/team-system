<?php

namespace teamsystem\data\invitations;
use wcf\data\DatabaseObjectEditor;

class InvitationEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'teamsystem\data\invitations\Invitation';
}