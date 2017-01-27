<?php

namespace tourneysystem\data\team;

use tourneysystem\data\platform\Platform;
use tourneysystem\data\TOURNEYSYSTEMDatabaseObject;
use wcf\data\DatabaseObject;
use wcf\data\ITitledLinkObject;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\system\request\IRouteController;
use wcf\data\user\User;
use tourneysystem\data\team\avatar\DefaultTeamAvatar;
use tourneysystem\data\team\avatar\TeamAvatar;
use wcf\data\user\UserProfile;

/**
 * Class Team
 * @package tourneysystem\data\team
 */
class Team extends TOURNEYSYSTEMDatabaseObject  implements IRouteController, ITitledLinkObject {
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'team';
	
	/**
	 * @see	\wcf\data\DatabaseObject::$databaseTableIndexName
	 */
	protected static $databaseTableIndexName = 'teamID';
	
	/**
	* team avatar
	* @var	\wcf\data\user\avatar\IUserAvatar
	*/
	protected $avatar = null;
	
	/**
	 * leader profile object
	 * @var	\wcf\data\user\UserProfile
	 */
	protected $leaderProfile = null;
	
	/**
	 * @see	\wcf\system\request\IRouteController::getTitle()
	 */
	public function getTitle() {
		return $this->teamName;
	}
	
	/**
	 * Returns the Team ID.
	 */
	public function getTeamID() {
		return $this->teamID;
	}
	
	/**
	 * Returns the Team name.
	 */
	public function getTeamName() {
		return $this->teamName;
	}
	
	/**
	 * Returns the Team tag.
	 */
	public function getTeamTag() {
		return $this->teamTag;
	}
	
	/**
	 * Returns the team's PlatformID.
	 */
	public function getPlatformID() {
		return $this->platformID;
	}
	
	/**
	 * Returns the platform.
	 */
	public function getPlatform() {
        $platform = new Platform($this->getPlatformID());
        return $platform->getPlatformName();
	}
	
	/**
	 * Returns true if the user is the team leader.
	 */
	public function isTeamLeader() {
		return WCF::getUser()->userID == $this->leaderID;
	}
	
	/**
	 * Returns true if the user is a team member.
	 */
	public function isTeamMember() {
		return (WCF::getUser()->getUserID() == $this->player2ID || WCF::getUser()->getUserID() == $this->player3ID || WCF::getUser()->getUserID() == $this->player4ID || WCF::getUser()->getUserID() == $this->sub1ID ||  WCF::getUser()->getUserID() == $this->sub2ID || WCF::getUser()->getUserID() == $this->sub3ID);
	}

    /**
     * Returns the positionID of the given player.
     *
     * @param $userID
     * @param $platformID
     * @param $teamID
     * @return int
     */
	public function getPositionID($userID, $platformID, $teamID) {
        $sql =      "SELECT positionID
                        FROM tourneysystem1_user_to_team_to_position_to_platform 
                        WHERE userID = ? AND platformID = ? AND teamID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($userID, $platformID, $teamID));

        $row = $statement->fetchArray();

        return $row['positionID'];
	}

    /**
     * Returns the userID of the team leader.
     *
     * @return int
     */
	public function getLeaderID()  {
		return $this->leaderID;
	}

    /**
     * Returns the name of the team leader.
     *
     * @return string
     */
	public function getLeaderName() {
		$leader = new User($this->leaderID);
		return $leader;
	}

    /**
     * Returns the userID of player 2.
     *
     * @return int
     */
	public function getPlayer2ID() {
		return $this->player2ID;
	}

    /**
     * Returns the name of player 2.
     *
     * @return string
     */
	public function getPlayer2Name() {
		$user = new User($this->player2ID);
		return $user;
	}

    /**
     * Returns the userID of player 3.
     *
     * @return int
     */
	public function getPlayer3ID() {
		return $this->player3ID;
	}

    /**
     * Returns the name of player 3.
     *
     * @return string
     */
	public function getPlayer3Name() {
		$user = new User($this->player3ID);
		return $user;
	}

    /**
     * Returns the userID of player 4.
     *
     * @return int
     */
	public function getPlayer4ID() {
		return $this->player4ID;
	}

    /**
     * Returns the name of player 4.
     *
     * @return string
     */
	public function getPlayer4Name() {
		$user = new User($this->player4ID);
		return $user;
	}

    /**
     * Returns the userID of sub 1.
     *
     * @return int
     */
	public function getSub1ID() {
		return $this->sub1ID;
	}

    /**
     * Returns the name of sub 1.
     *
     * @return string
     */
	public function getSub1Name() {
		$user = new User($this->sub1ID);
		return $user;
	}

    /**
     * Returns the userID of sub 2.
     *
     * @return int
     */
	public function getSub2ID() {
		return $this->sub2ID;
	}

    /**
     * Returns the name of sub 2.
     *
     * @return string
     */
	public function getSub2Name() {
		$user = new User($this->sub2ID);
		return $user;
	}

    /**
     * Returns the userID of sub 3.
     *
     * @return int
     */
	public function getSub3ID() {
		return $this->sub3ID;
	}

    /**
     * Returns the name of sub 3.
     *
     * @return string
     */
	public function getSub3Name() {
		$user = new User($this->sub3ID);
		return $user;
	}

    /**
     * Returns the number of members of a team.
     *
     * @return int
     */
	public function countMembers() {
        $sql = /** @lang MySQL */
            "SELECT userID
                  FROM tourneysystem1_user_to_team_to_position_to_platform
                  WHERE teamID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->getTeamID()));
        $int = 0;
        while($row = $statement->fetchArray()) {
            $int = $int + 1;
        }

        return $int;
    }

    /**
     * Returns an array of ids from all players of the team.
     *
     * @return array of match IDs
     */
	public function getPlayerIDs() {
        $sql = /** @lang MySQL */
            "SELECT userID
                  FROM tourneysystem1_user_to_team_to_position_to_platform
                  WHERE teamID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->getTeamID()));
        $array = array();
        while($row = $statement->fetchArray()) {
            $array[] = $row['userID'];
        }

        return $array;
    }

    /**
     * Returns the team's avatar.
     *
     * @return DefaultTeamAvatar|TeamAvatar
     */
	public function getAvatar() {
		if ($this->avatar === null) {
            if ($this->avatarID) {
                if (!$this->fileHash) {
                    $this->avatar = new TeamAvatar($this->avatarID);
                }
                else {
                    $this->avatar = new TeamAvatar(null, $this->getDecoratedObject()->data);
                }
            }
        }
			// use default avatar
			if ($this->avatar === null) {
				$this->avatar = new DefaultTeamAvatar();
			}
		return $this->avatar;
	}
	
	/**
	 * Returns the leader from this team
     *
	 * @return    \wcf\data\user\User
	 */
	public function getLeader() {
		return new User($this->leaderID);
	}
	
	/**
	 * Returns the user profile from this teams leader.
     *
	 * @return    \wcf\data\user\UserProfile
	 */
	public function getLeaderProfile() {
		return new UserProfile($this->getLeader());
	}
	
	/**
	 * Returns the contact from this team
     *
	 * @return    \wcf\data\user\User
	 */
	public function getContact() {
		return new User($this->contactID);
	}
	
	/**
	 * Returns the user profile from this teams contact.
     *
	 * @return    \wcf\data\user\UserProfile
	 */
	public function getContactProfile() {
		return new UserProfile($this->getContact());
	}

    /**
     * Returns the link to the object.
     *
     * @return    string
     */
    public function getLink() {
        return LinkHandler::getInstance()->getLink('Team', [
            'application' => 'tourneysystem',
            'object' => $this,
            'forceFrontend' => true
        ]);
    }
}