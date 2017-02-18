<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:25
 */

namespace tourneysystem\util;

use wcf\system\WCF;

/**
 * Class TourneyUtil
 * @package tourneysystem\util
 */
final class TourneyUtil {
    /**
     * Returns true if the given tourney name is a valid username.
     *
     * @param	string		$name
     * @return	boolean
     */
    public static function isValidTourneyName($name) {
        // minimum length is 2 characters, maximum length is 32 characters
        if (mb_strlen($name) < 2 || mb_strlen($name) > 32) {
            return false;
        }

        // check illegal characters
        if (!preg_match('/^[A-Z0-9 -]+$/i', $name)) {
            return false;
        }

        return true;
    }

    /**
     * Returns true if the given tourney name is available.
     *
     * @param	string		$name
     * @return	boolean
     */
    public static function isAvailableTourneyName($name) {

        $sql =		"SELECT	COUNT(teamname) AS count
						FROM	tourneysystem1_team
						WHERE	teamname = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($name));
        $row = $statement->fetchArray();

        return $row['count'] == 0;
    }

    /**
     * @param $string
     * @return int      id
     */
    public static function getTourneyIdByName($string) {
        $sql = /** @lang MySQL */
            "SELECT tourneyID
                        FROM    tourneysystem1_tourney
                        WHERE   tourneyName = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($string));
        $row = $statement->fetchArray();
        return $row['tourneyID'];
    }
}