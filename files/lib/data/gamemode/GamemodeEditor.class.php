<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:23
 */

namespace tourneysystem\data\gamemode;

use wcf\data\DatabaseObjectEditor;

class GamemodeEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\gamemode\Gamemode';
}