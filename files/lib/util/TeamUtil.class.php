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

        // check if not using dummy team name
        if (preg_match('/(D|d)(U|u)(M|m)(M|m)(Y|y)([0-9]){0,2}/i', $name)) {
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
		
		$sql =		"SELECT	COUNT(teamname) AS count
						FROM	teamsystem1_teams
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

        // check if not using dummy team tag
        if (preg_match('/(D|d)(Y|y)([0-9]){0,2}/i', $tag)) {
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
		
		$sql =		"SELECT	COUNT(teamtag) AS count
						FROM	teamsystem1_teams
						WHERE	teamtag = ?";
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($tag));
		$row = $statement->fetchArray();
		
		return $row['count'] == 0;

	}

    /**
     * Returns true if the player is not already in a team on the given platform.
     *
     * @param $platformID
     * @param $userID
     * @return bool
     * @internal param string $platform
     */
	 
	public static function isFreePlatformPlayer($platformID, $userID) {
        $sql =      "SELECT COUNT(teamID) AS count 
                        FROM teamsystem1_user_to_team_to_position_to_platform 
                        WHERE userID = ? AND platformID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($userID, $platformID));

        $row = $statement->fetchArray();

        return $row['count'] == 0;
	}

    /**
     * Returns the Team ID of a team using its name.
     *
     * @param $name
     * @return int
     */
	public function getTeamIDByName($name) {
        $sql =		"SELECT	teamID 
						FROM	teamsystem1_teams
						WHERE	teamname = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($name));
        $row = $statement->fetchArray();

        return $row['teamID'];
    }

    /**
     * Returns the Team ID of a team from a player.
     *
     * @param $platformID
     * @param $userID
     * @return int
     */
	public static function getPlayersTeamID($platformID, $userID) {
		
		$sql = "SELECT	teamID
				FROM	teamsystem1_teams
				WHERE	(platformID = ?) AND ((leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?))";

	
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($platformID, $userID, $userID, $userID, $userID, $userID, $userID, $userID));
		$value = $statement->fetchArray();
	
		return $value['teamID'];
	}

    /**
     * @return string
     */
    public function getDummyTeamName() {

        $sql =		"SELECT	COUNT(teamname) AS count
						FROM	teamsystem1_teams
						WHERE	teamname LIKE 'DUMMY%'";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $row = $statement->fetchArray();
        $index = $row['count'] + 1;

        return "DUMMY{$index}";
    }

    /**
     * @return string
     */
    public function getDummyTeamTag() {

        $sql =		"SELECT	COUNT(teamname) AS count
						FROM	teamsystem1_teams
						WHERE	teamname LIKE 'DUMMY%'";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $row = $statement->fetchArray();
        $index = $row['count'] + 1;

        return "DY{$index}";
    }

    /**
     * @return int
     */
    public function getDummyTeamID() {
        $sql =		"SELECT	COUNT(teamname) AS count
						FROM	teamsystem1_teams
						WHERE	teamname LIKE 'DUMMY%'";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $row = $statement->fetchArray();

        return $row;
    }

    /**
     * Returns an array of ids from all platforms.
     *
     * @return array
     */
    public static function getAllPlatforms() {
        $sql = /** @lang MySQL */
            "SELECT platformID
                  FROM teamsystem1_platforms";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $array = array();
        while($row = $statement->fetchArray()) {
            $array[] = $row['platformID'];
        }

        return $array;
    }

    /**
     * Returns true if the given player is not in the given team.
     *
     * @param $teamID
     * @param $userID
     * @return bool
     */
    public static function isNotInTeam($teamID, $userID) {
        $sql = "SELECT	*
				FROM	teamsystem1_teams
				WHERE	(teamID = ?) AND ((leaderID = ?) OR (player2ID = ?) OR (player3ID = ?) OR (player4ID = ?) OR (sub1ID = ?) OR (sub2ID = ?) OR (sub3ID = ?))";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($teamID, $userID, $userID, $userID, $userID, $userID, $userID, $userID));
        $value = $statement->fetchArray();

        return $value['teamID'] == 0;
    }

    /**
     * Returns the number of teams.
     *
     * @return int
     */
    public static function countTeams() {

        $sql = "SELECT	COUNT(teamID) AS count
				FROM	teamsystem1_teams";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $row = $statement->fetchArray();

        return $row['count'];

    }
}