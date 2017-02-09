<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 12:29
 */

namespace tourneysystem\data\rulebook\article;

use wcf\data\DatabaseObjectEditor;

class RulebookArticleEditor extends DatabaseObjectEditor {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\rulebook\article\RulebookArticle';
}