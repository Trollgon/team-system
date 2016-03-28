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
		
		$sql = "SELECT	COUNT(teamname) AS count
			FROM	tourneysystem1_teams
			WHERE	teamname = ?";
			
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($name));
		$row = $statement->fetchArray();
		return $row['count'] == 0;
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
		
		$sql = "SELECT	COUNT(teamtag) AS count
			FROM	tourneysystem1_teams
			WHERE	teamtag = ?";
			
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($tag));
		$row = $statement->fetchArray();
		return $row['count'] == 0;

	}
	
	/**
	 * Returns true if the player is not already in a team on the given platform.
	 * 
	 * @param	string		$platform
	 * @return	boolean
	 */
	 
	public static function isFreePlatformPlayer($platform, $user) {
		 
		$sql = "SELECT	*
			FROM	tourneysystem1_teams
			WHERE	platform = 4 AND (leaderID = 1 OR player2ID = 'user' OR player3ID = 'user' OR player4ID = 'user' OR sub1ID = 'user' OR sub2ID = 'user' OR sub3ID = 'user')";
			
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($platform));
		$row = $statement->fetchArray();
		return $row == 0;
		 
	}
}