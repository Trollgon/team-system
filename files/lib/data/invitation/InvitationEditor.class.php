<?php

namespace tourneysystem\data\invitation;
use wcf\data\DatabaseObjectEditor;

class InvitationEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'tourneysystem\data\invitation\Invitation';
}