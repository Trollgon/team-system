<?php
namespace teamsystem\util;
use wcf\system\WCF;
use wcf\data\user\User;

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
final class TeamContactsUtil {
	
	/**
	 * Returns true if the given name is a valid username.
	 * 
	 * @param	string		$name
	 * @return	boolean
	 */
	public static function hasMissingSub($teamID) {
		$sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((sub1ID IS NULL) OR (sub2ID IS NULL) OR (sub3ID IS NULL))";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID));
		$row = $statement->fetchArray();
		
		return $row['count'] == 3;
		
	}
}