<?php

namespace tourneysystem\data\team;
use wcf\data\DatabaseObjectEditor;

/**
 * Class TeamEditor
 * @package tourneysystem\data\team
 */
class TeamEditor extends DatabaseObjectEditor {
	/**
	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'tourneysystem\data\team\Team';
}