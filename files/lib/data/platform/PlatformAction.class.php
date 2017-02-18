<?php
/**
 * Created by Trollgon.
 * Date: 14.12.2016
 * Time: 11:45
 */

namespace tourneysystem\data\platform;


use wcf\data\AbstractDatabaseObjectAction;

class PlatformAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\platform\PlatformEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canEditPlatforms');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canEditPlatforms');
}