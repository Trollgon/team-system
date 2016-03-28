<?php
namespace tourneysystem\data\team;

use wcf\data\DatabaseObjectDecorator;
use wcf\data\IUserContent;
use wcf\data\user\User;
use wcf\data\user\UserProfile;
use wcf\system\request\LinkHandler;
use wcf\system\visitTracker\VisitTracker;
use wcf\system\WCF;

/*--------------------------------------------------------------------------------------------------
File       : ViewableNews.class.php
Description: viewable news object class
Copyright  : Olaf Braun © 2015
Author     : Olaf Braun
Last edit  : 01.03.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class TeamDecorator extends DatabaseObjectDecorator {
	/**
	 * @see    \wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	protected static $baseClass = 'tourneysystem\data\team\Team';
}
