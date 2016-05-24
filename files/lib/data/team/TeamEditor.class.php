<?php

namespace teamsystem\data\team;
use wcf\data\DatabaseObjectEditor;

class TeamEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'teamsystem\data\team\Team';
}