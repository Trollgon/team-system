<?php

namespace tourneysystem\page;

use wcf\system\WCF;
use wcf\page\SortablePage;
use tourneysystem\data\team\Xb1TeamList;

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

class Xb1TeamsListPage extends SortablePage {

	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */

	public $activeMenuItem = 'tourneysystem.header.menu.teams.xb360';

	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */

	public $objectListClassName = 'tourneysystem\data\team\Xb1TeamList';
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$itemsPerPage
	 */
	
	public $itemsPerPage = 20;
	
	public $defaultSortField = 'teamName';
	public $validSortFields = array('teamID');

	/**
	 * @see	\wcf\page\IPage::readParameters()
	 */

	public function readParameters() {

		parent::readParameters();
	
		$list =  new Xb1TeamList();
		$list->readObjects();
		$objects = $list->getObjects(); 
		
	}

}

