<?php

namespace teamsystem\page;

use teamsystem\data\invitations\InvitationList;
use teamsystem\data\team\TeamList;
use wcf\system\page\PageLocationManager;
use wcf\system\WCF;
use teamsystem\util\TeamUtil;
use wcf\page\SortablePage;

/**
 * Lists all teams.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.teamsystem
 */

class TeamListPage extends SortablePage {
	
	/**
	 * @see	\wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'teamsystem\data\team\TeamList';
	
	/**
	 * @see \wcf\page\AbstractPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();

        $teamList = new TeamList();

        $sql = /** @lang MySQL */
            "SELECT teamID
                  FROM teamsystem1_user_to_team_to_position_to_platform
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

