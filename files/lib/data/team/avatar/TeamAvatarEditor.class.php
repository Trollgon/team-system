<?php
namespace tourneysystem\data\team\avatar;
use wcf\data\DatabaseObjectEditor;
use wcf\system\WCF;

/**
 * Class TeamAvatarEditor
 * @package tourneysystem\data\team\avatar
 */
class TeamAvatarEditor extends DatabaseObjectEditor {

    /**
     * @inheritDoc
     */
    protected static $baseClass = TeamAvatar::class;

    /**
     * @inheritDoc
     */
    public function delete() {
        $sql = "DELETE FROM	tourneysystem1_team_avatar
			WHERE		avatarID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$this->avatarID]);

        $this->deleteFiles();
    }

    /**
     * @inheritDoc
     */
    public static function deleteAll(array $objectIDs = []) {
        $sql = "SELECT	*
			FROM	tourneysystem1_team_avatar
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
        // delete wcf2.1 files
        foreach (TeamAvatar::$avatarThumbnailSizes as $size) {
            if ($this->width < $size && $this->height < $size) break;

            @unlink($this->getLocation($size));
        }
        @unlink($this->getLocation('resize'));

        // delete original size
        @unlink($this->getLocation());
    }
}
