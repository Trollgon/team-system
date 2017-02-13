<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 17:49
 */

namespace tourneysystem\data\tourney;

use tourneysystem\data\game\Game;
use tourneysystem\data\gamemode\Gamemode;
use tourneysystem\data\platform\Platform;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamList;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use tourneysystem\util\TeamUtil;
use wcf\data\user\UserProfileList;
use wcf\system\request\IRouteController;
use wcf\system\WCF;

class Tourney extends TOURNEYSYSTEMDatabaseObject implements IRouteController {
    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableName
     */
    protected static $databaseTableName = 'tourney';

    /**
     * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
     */
    protected static $databaseTableIndexName = 'tourneyID';

    /**
     * @see wcf\system\request\IRouteController::getID()
     */
    public function getID() {
        return $this->tourneyID;
    }

    /**
     * Returns the title of the object.
     *
     * @return    string
     */
    public function getTitle() {
        return $this->tourneyName;
    }

    /**
     * @return int
     *
     * 0 - setup
     * 1 - sign up open
     * 2 - sign up closed
     * 3 - check-in open
     * 4 - check-in closed
     * 5 - tourney live
     * 6 - tourney over
     * 9 - tourney paused
     */
    public function getTourneyStatusID() {
        return $this->tourneyStatus;
    }

    public function getGameName() {
        $obj = new Game($this->gameID);
        return $obj->gameName;
    }

    public function getGamemodeName() {
        $obj = new Gamemode($this->gamemodeID);
        return $obj->gamemodeName;
    }

    public function getPlatform() {
        $obj = new Platform($this->platformID);
        return $obj;
    }

    public function getPlatformName() {
        $obj = new Platform($this->platformID);
        return $obj->getPlatformName();
    }

    /**
     * @param $userID
     * @return bool
     */
    public function userCanSignUp($userID) {
        if ($this->participantType == 1) {
            $team = new Team(TeamUtil::getPlayersTeamID($this->getPlatform()->getID(), $userID));
            $sql = /** @lang MySQL */
                "SELECT COUNT(tourneyID)  AS count
                        FROM    tourneysystem1_sign_up
                        WHERE   tourneyID = ? AND participantID = ?";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array($this->getID(), $team->getTeamID()));
            $row = $statement->fetchArray();
            return ( $row['count'] == 0 && ($this->maxParticipants > $this->countParticipants() || $this->maxParticipants == null) && $team->isTeamLeader() && $this->getTourneyStatusID() == 1);
        }
    }

    /**
     * @param $userID
     * @return bool
     */
    public function userCanSignOff($userID) {
        if ($this->participantType == 1) {
            $team = new Team(TeamUtil::getPlayersTeamID($this->getPlatform()->getID(), $userID));
            $sql = /** @lang MySQL */
                "SELECT COUNT(tourneyID)  AS count
                        FROM    tourneysystem1_sign_up
                        WHERE   tourneyID = ? AND participantID = ?";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array($this->getID(), $team->getTeamID()));
            $row = $statement->fetchArray();
            return ($row['count'] == 1 && $team->isTeamLeader() && $this->getTourneyStatusID() == 1);
        }
    }

    /**
     * @return int
     */
    public function countParticipants() {
        return count($this->getSignUp());
    }

    /**
     * Returns an array of ids from all referees for this tourney.
     *
     * @return UserProfileList
     */
    public function getReferees() {
        $sql = /** @lang MySQL */
            "SELECT userID
                  FROM tourneysystem1_referee_to_tourney
                  WHERE tourneyID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->getID()));
        $array = array();
        while($row = $statement->fetchArray()) {
            $array[] = $row['userID'];
        }
        $creator = array($this->creatorID);
        array_merge($creator, $array);

        $list = new UserProfileList();
        $list->setObjectIDs($array);
        $list->readObjects();
        return $list;
    }

    /**
     * @param $userID
     * @return bool
     */
    public function isReferee($userID) {
        if ($this->creatorID == $userID) {
            return true;
        }
        else {
            $sql = /** @lang MySQL */
                "SELECT COUNT(tourneyID)  AS count
                        FROM    tourneysystem1_referee_to_tourney
                        WHERE   userID = ?";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array($userID));
            $row = $statement->fetchArray();
            return $row['count'] == 1;
        }
    }

    /**
     * @param $userID
     * @return bool
     */
    public function addReferee($userID) {
        $sql = "INSERT INTO tourneysystem1_referee_to_tourney (userID, tourneyID)
                  VALUES (?, ?)";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($userID, $this->getID()));
    }

    /**
     * @param $userID
     * @return bool
     */
    public function kickReferee($userID) {
        $sql = "DELETE FROM tourneysystem1_referee_to_tourney
                  WHERE userID = ? AND tourneyID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($userID, $this->getID()));
    }

    /**
     * Returns a list all signed up participants for this tourney.
     *
     * @return TeamList
     */
    public function getSignUp() {
        $tourney = new Tourney($this->getID());
        if ($tourney->participantType == 1) {
            $sql = /** @lang MySQL */
                "SELECT tourneysystem1_team.teamID
                  FROM tourneysystem1_sign_up, tourneysystem1_team
                  WHERE tourneysystem1_sign_up.participantID = tourneysystem1_team.teamID AND tourneysystem1_sign_up.tourneyID = ?";
            $statement = WCF::getDB()->prepareStatement($sql);
            $statement->execute(array($this->getID()));
            $array = array();
            while($row = $statement->fetchArray()) {
                $array[] = $row['teamID'];
            }

            $list = new TeamList();
            $list->setObjectIDs($array);
            $list->readObjects();

            return $list;
        }
    }
}