<?php
namespace teamsystem\util;
use wcf\system\WCF;

/**
 * Contains team-related functions.
 * 
 * @author	Trollgon
 * @copyright	2001-2015 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	util
 * @category	Community Framework
 */
final class TeamInvitationUtil {
	
	public static function isEmptyPosition($teamID, $positionID) {
		switch ($positionID) {
			case 1:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((player2ID IS NULL) OR (player3ID IS NULL) OR (player4ID IS NULL))";
				break;
			case 2:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((sub1ID IS NULL) OR (sub2ID IS NULL) OR (sub3ID IS NULL))";
				break;			
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID));
		$row = $statement->fetchArray();
		
		return $row['count'] != 0;
	}
	
	public static function isNotInTeam($teamID, $userID) {
		$sql = "SELECT	*
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?))";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID, $userID, $userID, $userID, $userID, $userID, $userID, $userID));
		$value = $statement->fetchArray();
		
		return $value['teamID'] == 0;
	}
	
	public static function getFreePositionID($teamID, $position) {
		switch ($position) {
			case 1:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (player2ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 1;
					break;
				}
				
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (player3ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 2;
					break;
				}
				
						$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (player4ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID,));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 3;
					break;
				}
				
				break;
			case 2:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (sub1ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 4;
					break;
				}
				
		$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (sub2ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 5;
					break;
				}
				
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND (sub3ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 6;
					break;
				}
		}
		
		return $backEndPositionID;
	}
	
}