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
final class TeamUtil {
	/**
	 * Returns true if the given name is a valid username.
	 * 
	 * @param	string		$name
	 * @return	boolean
	 */
	public static function isValidTeamname($name) {
		// minimum length is 2 characters, maximum length is 32 characters
		if (mb_strlen($name) < 2 || mb_strlen($name) > 32) {
			return false;
		}
		// check illegal characters
		if (!preg_match('!^[^,\n]+$!', $name)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Returns true if the given teamname is available.
	 * 
	 * @param	string		$name
	 * @return	boolean
	 */
	public static function isAvailableTeamname($name) {
		
		$databases = array(
				"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_teams_pc
						WHERE	teamname = ?",
				"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_teams_ps4
						WHERE	teamname = ?",
				"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_teams_ps3
						WHERE	teamname = ?",
				"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_teams_xb1
						WHERE	teamname = ?",
				"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_teams_xb360
						WHERE	teamname = ?"
		);
		
		$row = 0;
		
		foreach ($databases as &$sql) {
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array($name));
			$rowAdd = $statement->fetchArray();
			$row = $row + $rowAdd['count'];
		}
		
		return $row == 0;
	}

	/**
	 * Returns true if the given tag is a valid teamtag.
	 * 
	 * @param	string		$tag
	 * @return	boolean
	 */

	public static function isValidTeamtag($tag) {

		// minimum length is 2 characters, maximum length is 4 characters
		if (mb_strlen($tag) < 2 || mb_strlen($tag) > 4) {
			return false;
		}

		// check illegal characters
		if (!preg_match('!^[^,\n]+$!', $tag)) {
			return false;
		}
		
		return true;
	}

	/**
	 * Returns true if the given teamtag is available.
	 * 
	 * @param	string		$tag
	 * @return	boolean
	 */

	public static function isAvailableTeamtag($tag) {
		
		$databases = array(
				"SELECT	COUNT(teamtag) AS count
						FROM	tourneysystem1_teams_pc
						WHERE	teamtag = ?",
				"SELECT	COUNT(teamtag) AS count
						FROM	tourneysystem1_teams_ps4
						WHERE	teamtag = ?",
				"SELECT	COUNT(teamtag) AS count
						FROM	tourneysystem1_teams_ps3
						WHERE	teamtag = ?",
				"SELECT	COUNT(teamtag) AS count
						FROM	tourneysystem1_teams_xb1
						WHERE	teamtag = ?",
				"SELECT	COUNT(teamtag) AS count
						FROM	tourneysystem1_teams_xb360
						WHERE	teamtag = ?"
		);
		
		$row = 0;
		
		foreach ($databases as &$sql) {
			$statement = WCF::getDB()->prepareStatement($sql);
			$statement->execute(array($tag));
			$rowAdd = $statement->fetchArray();
			$row = $row + $rowAdd['count'];
		}
		
		return $row == 0;

	}
	
	/**
	 * Returns true if the player is not already in a team on the given platform.
	 * 
	 * @param	string		$platform
	 * @return	boolean
	 */
	 
	public static function isFreePlatformPlayer($platformID, $role, $user) {
		
		switch ($platformID) {
			case 1:
				$sql = "SELECT	COUNT(" . $role . ") AS count
						FROM	tourneysystem1_teams_pc
						WHERE	" . $role . " = ?";
				break;
			case 2:
				$sql = "SELECT	COUNT(" . $role . ") AS count
						FROM	tourneysystem1_teams_ps4
						WHERE	" . $role . " = ?";
				break;
			case 3:
				$sql = "SELECT	COUNT(" . $role . ") AS count
						FROM	tourneysystem1_teams_ps3
						WHERE	" . $role . " = ?";
				break;
			case 4:
				$sql = "SELECT	COUNT(" . $role . ") AS count
						FROM	tourneysystem1_teams_xb1
						WHERE	" . $role . " = ?";
				break;
			case 5:
				$sql = "SELECT	COUNT(" . $role . ") AS count
						FROM	tourneysystem1_teams_xb360
						WHERE	" . $role . " = ?";
				break;
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($user));
		$row = $statement->fetchArray();
		
		
		return $row['count'] == 0;
		 
	}
	
	/**
	 * Returns the Team ID of a team from a player.
	 */
	public function getPlayersTeamID($platformID, $userID) {
		switch ($platformID) {
			case 1:
				$sql = "SELECT	teamID
						FROM	tourneysystem1_teams_pc
						WHERE	(leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 2:
				$sql = "SELECT	teamID
						FROM	tourneysystem1_teams_ps4
						WHERE	(leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 3:
				$sql = "SELECT	teamID
						FROM	tourneysystem1_teams_ps3
						WHERE	(leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 4:
				$sql = "SELECT	teamID
						FROM	tourneysystem1_teams_xb1
						WHERE	(leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
			case 5:
				$sql = "SELECT	teamID
						FROM	tourneysystem1_teams_xb360
						WHERE	(leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?)";
				break;
		}
	
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($userID, $userID, $userID, $userID, $userID, $userID, $userID));
		$value = $statement->fetchArray();
	
		return $value['teamID'];
	}
}