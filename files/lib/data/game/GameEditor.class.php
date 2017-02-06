<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:22
 */

namespace tourneysystem\data\game;

use wcf\data\DatabaseObjectEditor;

class GameEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\game\Game';
}