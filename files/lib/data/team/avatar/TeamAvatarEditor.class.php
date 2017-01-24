<?php

namespace teamsystem\data\team\avatar;

use wcf\data\DatabaseObjectEditor;

use wcf\system\WCF;



/**

 * Provides functions to edit avatars.

 * 

 * @author	Alexander Ebert

 * @copyright	2001-2015 WoltLab GmbH

 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>

 * @package	com.woltlab.wcf

 * @subpackage	data.user.avatar

 * @category	Community Framework

 */

class TeamAvatarEditor extends DatabaseObjectEditor {

	/**

	 * @see	\wcf\data\DatabaseObjectDecorator::$baseClass

	 */

	protected static $baseClass = 'teamsystem\data\team\avatar\TeamAvatar';
	
	/**
	 * @see    \wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'teamsystem1_team_avatar';
	}

	/**

	 * @see	\wcf\data\IEditableObject::delete()

	 */

	public function delete() {

		$sql = "DELETE FROM	teamsystem1_team_avatar

			WHERE		avatarID = ?";

		$statement = WCF::getDB()->prepareStatement($sql);

		$statement->execute(array($this->avatarID));

		

		$this->deleteFiles();

	}

	

	/**

	 * @see	\wcf\data\IEditableObject::deleteAll()

	 */

	public static function deleteAll(array $objectIDs = array()) {

		$sql = "SELECT	*

			FROM	teamsystem1_team_avatar

			WHERE	avatarID IN (".str_repeat('?,', count($objectIDs) - 1)."?)";

		$statement = WCF::getDB()->prepareStatement($sql);

		$statement->execute($objectIDs);

		while ($avatar = $statement->fetchObject(self::$baseClass)) {

			$editor = new TeamAvatarEditor($avatar);

			$editor->deleteFiles();

		}

		

		return parent::deleteAll($objectIDs);

	}

	

	/**

	 * Deletes avatar files.

	 */

	public function deleteFiles() {

		foreach (TeamAvatar::$avatarThumbnailSizes as $size) {

			if ($this->width < $size && $this->height < $size) break;

			

			@unlink($this->getLocation($size));

		}

		@unlink($this->getLocation('resize'));

		

		// delete original size

		@unlink($this->getLocation());

	}

}

