<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:20
 */

namespace tourneysystem\data\gamemode;

use wcf\data\AbstractDatabaseObjectAction;

class GamemodeAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\gamemode\GameModeEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canEditGamemodes');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canEditGamemodes');
}