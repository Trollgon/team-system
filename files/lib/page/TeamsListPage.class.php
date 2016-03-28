<?php

namespace tourneysystem\page;

use tourneysystem\data\team\TeamList;

use wcf\data\search\Search;

use wcf\page\SortablePage;

use wcf\system\dashboard\DashboardHandler;

use wcf\system\database\PostgreSQLDatabase;

use wcf\system\exception\IllegalLinkException;

use wcf\system\request\LinkHandler;

use wcf\system\user\collapsible\content\UserCollapsibleContentHandler;

use wcf\system\WCF;

use wcf\util\HeaderUtil;



/**

 * Shows members page.

 * 

 * @author	Marcel Werk

 * @copyright	2001-2015 WoltLab GmbH

 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>

 * @package	com.woltlab.wcf

 * @subpackage	page

 * @category	Community Framework

 */

class TeamsListPage extends SortablePage {

	/**

	 * @see	\wcf\page\AbstractPage::$activeMenuItem

	 */

	public $activeMenuItem = 'tourneysystem.header.menu.teams';

	

	/**

	 * @see	\wcf\page\MultipleLinkPage::$itemsPerPage

	 */

	public $itemsPerPage = 20;

	
	/**

	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName

	 */

	public $objectListClassName = 'tourneysystem\data\team\TeamList';
	
	public $defaultSortField = 'teamName';
	public $validSortFields = array('teamID');

	/**

	 * @see	\wcf\page\IPage::readParameters()

	 */

	public function readParameters() {

		parent::readParameters();
	
		$list =  new TeamList();
		$list->readObjects();
		$objects = $list->getObjects(); 
		
	}

}

