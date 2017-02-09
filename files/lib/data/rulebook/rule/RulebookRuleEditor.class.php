<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:38
 */

namespace tourneysystem\data\rulebook\rule;

use wcf\data\DatabaseObjectEditor;

class RulebookRuleEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\rulebook\rule\RulebookRule';
}