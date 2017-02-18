<?php
/**
 * Created by Trollgon.
 * Date: 16.12.2016
 * Time: 13:40
 */

namespace tourneysystem\data\platform;


use wcf\data\DatabaseObjectList;

class PlatformList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\platform\Platform';
}