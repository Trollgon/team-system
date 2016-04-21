<?php

namespace tourneysystem\page;

use wcf\page\AbstractPage;

use wcf\system\WCF;
use tourneysystem\util\TeamUtil;

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

class TeamsListPage extends AbstractPage {

	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'tourneysystem.header.menu.teams';

	

	/**
	 * @see	\wcf\page\MultipleLinkPage::$itemsPerPage
	 */
	public $itemsPerPage = 20;
	
	public $defaultSortField = 'teamName';
	public $validSortFields = array('teamID');
	
	
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		$pcTeamID = TeamUtil::getPlayersTeamID(1, WCF::getUser()->userID);
		$ps4TeamID = TeamUtil::getPlayersTeamID(2, WCF::getUser()->userID);
		$ps3TeamID = TeamUtil::getPlayersTeamID(3, WCF::getUser()->userID);
		$xb1TeamID = TeamUtil::getPlayersTeamID(4, WCF::getUser()->userID);
		$xb360TeamID = TeamUtil::getPlayersTeamID(5, WCF::getUser()->userID);
		WCF::getTPL()->assign(array(
			'pcTeamID' 		=> $pcTeamID,
			'ps4TeamID'		=> $ps4TeamID,
			'ps3TeamID'		=> $ps3TeamID,
			'xb1TeamID'		=> $xb1TeamID,
			'xb360TeamID'	=> $xb360TeamID,
		));
	}

}

