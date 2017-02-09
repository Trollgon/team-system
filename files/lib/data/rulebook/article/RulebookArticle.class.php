<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:27
 */

namespace tourneysystem\data\rulebook\article;

use tourneysystem\data\rulebook\rule\RulebookRuleList;
use tourneysystem\data\rulebook\Rulebook;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\system\request\IRouteController;

class RulebookArticle extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'rulebook_article';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'rulebookArticleID';

    /**
     * @see wcf\system\request\IRouteController::getTitle()
     */
    public function getTitle() {
        return $this->rulebookArticleName;
    }

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->rulebookArticleID;
    }

    public function getRulebook() {
        $obj = new Rulebook($this->rulebookID);
        return $obj;
    }

    public function getRules() {
        $objectList = new RulebookRuleList();
        $objectList->getConditionBuilder()->add('tourneysystem1_rulebook_rule.articleID = ?', array($this->rulebookArticleID));
        return $objectList;
    }
}