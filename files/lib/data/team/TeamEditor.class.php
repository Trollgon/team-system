<?php

namespace teamsystem\data\team;
use wcf\data\DatabaseObjectEditor;

/**
 * Class TeamEditor
 * @package teamsystem\data\team
 */
class TeamEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'teamsystem\data\team\Team';
}