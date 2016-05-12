<?php
namespace tourneysystem\util;
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
	
	public function isEmptyPosition($platformID, $teamID, $positionID) {
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
		
		switch ($platformID) {
			case 1:
				$sql = "SELECT	" . $positionID . "
						FROM	tourneysystem1_teams_pc
						WHERE	" . $role . " = ?";
				break;
			case 2:
				$sql = "SELECT	" . $positionID . "
						FROM	tourneysystem1_teams_ps4
						WHERE	" . $role . " = ?";
				break;
			case 3:
				$sql = "SELECT	" . $positionID . "
						FROM	tourneysystem1_teams_ps3
						WHERE	" . $role . " = ?";
				break;
			case 4:
				$sql = "SELECT	" . $positionID . "
						FROM	tourneysystem1_teams_xb1
						WHERE	" . $role . " = ?";
				break;
			case 5:
				$sql = "SELECT	" . $positionID . "
						FROM	tourneysystem1_teams_xb360
						WHERE	" . $role . " = ?";
				break;
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array("NULL"));
		$row = $statement->fetchArray();
		
		return $row == 0;
	}
	
	public function isNotInTeam($platformID, $teamID, $userID) {
		switch ($platformID) {
			case 1:
				$sql = "SELECT	*
						FROM	tourneysystem1_teams_pc
						WHERE	(teamID = ?) AND (leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 2:
				$sql = "SELECT	*
						FROM	tourneysystem1_teams_ps4
						WHERE	(teamID = ?) AND (leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 3:
				$sql = "SELECT	*
						FROM	tourneysystem1_teams_ps3
						WHERE	(teamID = ?) AND (leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 4:
				$sql = "SELECT	*
						FROM	tourneysystem1_teams_xb1
						WHERE	(teamID = ?) AND (leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 5:
				$sql = "SELECT	*
						FROM	tourneysystem1_teams_xb360
						WHERE	(teamID = ?) AND (leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID, $userID, $userID, $userID, $userID, $userID, $userID, $userID));
		$value = $statement->fetchArray();
		
		return $value['teamID'] == 0;
	}
	
}