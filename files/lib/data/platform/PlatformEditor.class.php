<?php
/**
 * Created by Trollgon.
 * Date: 14.12.2016
 * Time: 11:46
 */

namespace tourneysystem\data\platform;


use wcf\data\DatabaseObjectEditor;

class PlatformEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\platform\Platform';
}