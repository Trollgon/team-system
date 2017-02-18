<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:29
 */

namespace tourneysystem\data\rulebook\article;

use wcf\data\AbstractDatabaseObjectAction;

class RulebookArticleAction extends AbstractDatabaseObjectAction {
    /**
     * @see	\wcf\data\AbstractDatabaseObjectAction::$className
     */
    public $className = 'tourneysystem\data\rulebook\article\RulebookArticleEditor';

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsDelete
     */
    protected $permissionsDelete = array('admin.tourneySystem.canCreateRulebooks');

    /**
     * @see \wcf\data\AbstractDatabaseObjectAction::$permissionsUpdate
     */
    protected $permissionsUpdate = array('admin.tourneySystem.canCreateRulebooks');
}