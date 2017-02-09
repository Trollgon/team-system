<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:34
 */

namespace tourneysystem\data\rulebook\rule;

use tourneysystem\data\rulebook\article\RulebookArticle;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

class RulebookRule extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'rulebook_rule';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'ruleID';

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return substr($this->text, 0, 10);
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->ruleID;
    }

    public function getArticle() {
        $obj = new RulebookArticle($this->articleID);
        return $obj;
    }
}