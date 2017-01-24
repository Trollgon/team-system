<?php
/**
 * Created by Trollgon.
 * Date: 29.12.2016
 * Time: 15:52
 */

namespace teamsystem\acp\page;
use wcf\page\SortablePage;

class PlatformListPage extends SortablePage {

    public $activeMenuItem = 'wcf.acp.menu.link.teamsystem.platform.list';

    public $objectListClassName = 'teamsystem\data\platform\PlatformList';

}