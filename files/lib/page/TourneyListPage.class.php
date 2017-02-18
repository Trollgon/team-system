<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 13:01
 */

namespace tourneysystem\page;

use wcf\page\SortablePage;

class TourneyListPage extends SortablePage {
    /**
     * @see	\wcf\page\MultipleLinkPage::$objectListClassName
     */
    public $objectListClassName = 'tourneysystem\data\tourney\TourneyList';
}