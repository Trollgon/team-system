<?php
namespace teamsystem\data\team\avatar;
use teamsystem\data\TEAMSYSTEMDatabaseObject;
use wcf\data\user\avatar\IUserAvatar;
use wcf\util\StringUtil;
use wcf\system\WCF;

/**
 * Class TeamAvatar
 * @package teamsystem\data\team\avatar
 */
class TeamAvatar extends TEAMSYSTEMDatabaseObject implements IUserAvatar  {

    public static $databaseTableName = 'team_avatar';
    /**
     * needed avatar thumbnail sizes
     * @var	integer[]
     * @deprecated 3.0
     */
    public static $avatarThumbnailSizes = [32, 96, 128, 256];

    /**
     * maximum thumbnail size
     * @var	integer
     * @deprecated 3.0
     */
    public static $maxThumbnailSize = 128;

    /**
     * minimum height and width of an uploaded avatar
     * @var	integer
     * @deprecated 3.0
     */
    const MIN_AVATAR_SIZE = 96;

    /**
     * minimum height and width of an uploaded avatar
     * @var	integer
     */
    const AVATAR_SIZE = 128;

    /**
     * Returns the physical location of this avatar.
     *
     * @param	integer		$size
     * @return	string
     */
    public function getLocation($size = null) {
        return RELATIVE_TEAMSYSTEM_DIR . 'images/avatars/' . $this->getFilename($size);
    }

    /**
     * Returns the file name of this avatar.
     *
     * @param	integer		$size
     * @return	string
     */
    public function getFilename($size = null) {
        return substr($this->fileHash, 0, 2) . '/' . $this->avatarID . '-' . $this->fileHash . ($size !== null ? ('-' . $size) : '') . '.' . $this->avatarExtension;
    }

    /**
     * @inheritDoc
     */
    public function getURL($size = null) {
        return WCF::getPath('teamsystem') . 'images/avatars/' . $this->getFilename();
    }

    /**
     * @inheritDoc
     */
    public function getImageTag($size = null) {
        return '<img src="'.StringUtil::encodeHTML($this->getURL($size)).'" style="width: '.$size.'px; height: '.$size.'px" alt="" class="userAvatarImage">';
    }

    /**
     * @inheritDoc
     */
    public function getCropImageTag($size = null) {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function canCrop() {
        return false;
    }
}
