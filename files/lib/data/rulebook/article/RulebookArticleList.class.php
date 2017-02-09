<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:29
 */

namespace tourneysystem\data\rulebook\article;

use wcf\data\DatabaseObjectList;

class RulebookArticleList extends DatabaseObjectList {
    /**
     * @see    \wcf\data\DatabaseObjectList::$className
     */
    public $className = 'tourneysystem\data\rulebook\article\RulebookArticle';
}