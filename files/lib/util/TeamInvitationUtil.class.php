<?php
namespace tourneysystem\util;
use wcf\system\WCF;

/**
 * Class TeamInvitationUtil
 * @package tourneysystem\util
 */
final class TeamInvitationUtil {

    /**
     * Checks if the given position is empty.
     *
     * @param $teamID
     * @param $positionID
     * @return bool
     */
	public static function isEmptyPosition($teamID, $positionID) {
		switch ($positionID) {
			case 1:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND ((player2ID IS NULL) OR (player3ID IS NULL) OR (player4ID IS NULL))";
				break;
			case 2:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND ((sub1ID IS NULL) OR (sub2ID IS NULL) OR (sub3ID IS NULL))";
				break;			
		}
		
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($teamID));
		$row = $statement->fetchArray();
		
		return $row['count'] != 0;
	}

    /**
     * Returns the positionID used in the database.
     *
     * @param $teamID
     * @param $position
     * @return int
     */
	public static function getFreePositionID($teamID, $position) {
		switch ($position) {
			case 1:
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND (player2ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 1;
					break;
				}
				
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND (player3ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 2;
					break;
				}
				
						$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
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
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND (sub1ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 4;
					break;
				}
				
		$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
				WHERE	(teamID = ?) AND (sub2ID IS NULL)";
				
				$statement = WCF::getDB()->prepareStatement($sql);
				$statement->execute(array($teamID));
				$row = $statement->fetchArray();
				
				if ($row['count'] == 1) {
					$backEndPositionID = 5;
					break;
				}
				
				$sql = "SELECT	COUNT(teamID) AS count
				FROM	tourneysystem1_team
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

    /**
     * Returns true if there isn't already an invitation from the given team for the given user.
     *
     * @param $teamID
     * @param $userID
     * @return bool
     */
	public static function checkDoubleInvitations($teamID, $userID) {

        $sql = "SELECT	COUNT(invitationID) AS count
				FROM	tourneysystem1_invitation
				WHERE	(teamID = ?) AND (playerID = ?)";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($teamID, $userID));
        $row = $statement->fetchArray();

        return $row['count'] == 0;

    }

    /**
     * Returns the number of invitations for a given player.
     *
     * @param $userID
     * @return int
     */
    public static function countInvitations($userID) {

        $sql = "SELECT	COUNT(invitationID) AS count
				FROM	tourneysystem1_invitation
				WHERE	(playerID = ?)";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($userID));
        $row = $statement->fetchArray();

        return $row['count'];

    }
}