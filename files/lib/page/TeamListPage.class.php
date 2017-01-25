<?php

namespace tourneysystem\page;

use tourneysystem\data\invitations\InvitationList;
use tourneysystem\data\team\TeamList;
use wcf\system\WCF;
use tourneysystem\util\TeamUtil;
use wcf\page\SortablePage;

/**
 * Lists all teams.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamListPage extends SortablePage {
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'tourneysystem\data\team\TeamList';
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

        $teamList = new TeamList();

        $sql = /** @lang MySQL */
            "SELECT teamID
                  FROM tourneysystem1_user_to_team_to_position_to_platform
                  WHERE userID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array(WCF::getUser()->getUserID()));
        $array = array();
        while($row = $statement->fetchArray()) {
            $array[] = $row['teamID'];
        }

        $teamList->setObjectIDs($array);
        $teamList->readObjects();

        $invitationsList = new InvitationList();
        $invitationsList->getConditionBuilder()->add("invitations.playerID = ?", array(WCF::getUser()->getUserID()));

		WCF::getTPL()->assign(array(
		    'teamsCount'        =>  TeamUtil::countTeams(),
			'teamList'          =>  $teamList,
            'invitations'       =>  $invitationsList->countObjects(),
		));
	}

}

