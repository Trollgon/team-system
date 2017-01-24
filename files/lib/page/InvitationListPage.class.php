<?php

namespace teamsystem\page;

use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use wcf\page\SortablePage;
use teamsystem\data\invitations\InvitationList;

/**
 * Lists Invitations for a user.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */

class InvitationListPage extends SortablePage {
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */

	public $objectListClassName = 'teamsystem\data\invitations\InvitationList';
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$itemsPerPage
	 */
	
	public $itemsPerPage = 20;
	
	public $defaultSortField = 'teamID';
	public $validSortFields = array('teamID');

    /**
     * @see \wcf\page\AbstractPage::readData()
     */
    public function readData() {
        parent::readData();

        PageLocationManager::getInstance()->addParentLocation("de.trollgon.teamsystem.TeamList");
    }

	/**
	 * @see \wcf\page\MultipleLinkPage::initObjectList()
	 */
	protected function initObjectList() {
		parent::initObjectList();
		
		$this->objectList->getConditionBuilder()->add("invitations.playerID = ?", array(WCF::getUser()->getUserID()));
	}
}

