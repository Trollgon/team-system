<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:19
 */

namespace tourneysystem\data\game;

use wcf\data\AbstractDatabaseObjectAction;

class GameAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\game\GameEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canEditGames');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canEditGames');
}