<?php
namespace teamsystem\util;
use wcf\system\WCF;

/**
 * Contains user-related functions.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2015 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	util
 * @category	Community Framework
 */
final class TeamInvitationUtil {
	
	public function isEmptyPosition($teamID, $positionID) {
		switch ($positionID) {
			case 1:
				$role = "player2ID";
				break;
			case 2:
				$role = "player3ID";
				break;
			case 3:
				$role = "player4ID";
				break;
			case 4:
				$role = "sub1ID";
				break;
			case 5:
				$role = "sub2ID";
				break;
			case 6:
				$role = "sub3ID";
				break;			
		}
		
		$sql = "SELECT	" . $positionID . "
				FROM	teamsystem1_teams
				WHERE	" . $role . " = ?";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array("NULL"));
		$row = $statement->fetchArray();
		
		return $row == 0;
	}
	
	public function isNotInTeam($teamID, $userID) {
		$sql = "SELECT	*
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?))";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID, $userID, $userID, $userID, $userID, $userID, $userID, $userID));
		$value = $statement->fetchArray();
		
		return $value['teamID'] == 0;
	}
	
}