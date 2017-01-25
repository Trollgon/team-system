<?php

namespace tourneysystem\data\invitations;
use wcf\data\DatabaseObjectEditor;

class InvitationEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'tourneysystem\data\invitations\Invitation';
}