<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:17
 */

namespace tourneysystem\data\rulebook;

use tourneysystem\data\rulebook\article\RulebookArticleList;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

/**
 * Class Rulebook
 * @package tourneysystem\data\rulebook
 */
class Rulebook extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'rulebook';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'rulebookID';

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return $this->rulebookName;
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->rulebookID;
    }

    public function getArticles() {
        $objectList = new RulebookArticleList();
        $objectList->getConditionBuilder()->add('tourneysystem1_rulebook_article.rulebookID = ?', array($this->rulebookID));
        return $objectList;
    }
}