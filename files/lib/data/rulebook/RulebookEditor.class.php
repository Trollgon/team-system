<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:23
 */

namespace tourneysystem\data\rulebook;

use wcf\data\DatabaseObjectEditor;

class RulebookEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\rulebook\Rulebook';
}