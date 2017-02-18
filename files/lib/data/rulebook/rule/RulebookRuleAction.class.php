<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:37
 */

namespace tourneysystem\data\rulebook\rule;

use wcf\data\AbstractDatabaseObjectAction;

class RulebookRuleAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\rulebook\rule\RulebookRuleEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canCreateRulebooks');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canCreateRulebooks');
}