<?php
namespace tourneysystem\util;
use wcf\system\WCF;

/**
 * Class TeamUtil
 * @package tourneysystem\util
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
		if (!preg_match('/^[A-Z0-9 -]+$/i', $name)) {
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
						FROM	tourneysystem1_team
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
		if (!preg_match('^[A-Z0-9]+$^', $tag)) {
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
						FROM	tourneysystem1_team
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
                        FROM tourneysystem1_user_to_team_to_position_to_platform 
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
						FROM	tourneysystem1_team
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
				FROM	tourneysystem1_team
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
						FROM	tourneysystem1_team
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
						FROM	tourneysystem1_team
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
						FROM	tourneysystem1_team
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
                  FROM tourneysystem1_platform";

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
				FROM	tourneysystem1_team
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
				FROM	tourneysystem1_team";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array());
        $row = $statement->fetchArray();

        return $row['count'];

    }

    /**
     * @param $teamID
     * @return bool
     */
    public static function hasMissingSub($teamID) {
        $sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND ((sub1ID IS NULL) OR (sub2ID IS NULL) OR (sub3ID IS NULL))";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($teamID));
        $row = $statement->fetchArray();

        return $row['count'] == 3;

    }
}