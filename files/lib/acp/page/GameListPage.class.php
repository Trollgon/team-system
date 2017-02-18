<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:29
 */

namespace tourneysystem\acp\page;

use wcf\page\SortablePage;

class GameListPage extends SortablePage {
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.game.list';

    public $objectListClassName = 'tourneysystem\data\game\GameList';
}