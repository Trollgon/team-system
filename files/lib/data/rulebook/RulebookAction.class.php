<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:21
 */

namespace tourneysystem\data\rulebook;

use wcf\data\AbstractDatabaseObjectAction;

class RulebookAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\rulebook\RulebookEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canCreateRulebooks');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canCreateRulebooks');
}