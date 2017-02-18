<?php
/**
 * Created by Trollgon.
 * Date: 29.12.2016
 * Time: 15:52
 */

namespace tourneysystem\acp\page;

use wcf\page\SortablePage;

class PlatformListPage extends SortablePage {
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.platform.list';

    public $objectListClassName = 'tourneysystem\data\platform\PlatformList';
}