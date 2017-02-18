<?php
/**
 * Created by Trollgon.
 * Date: 18.02.2017
 * Time: 18:59
 */

namespace tourneysystem\data\tourney\avatar;


use tourneysystem\data\team\avatar\TeamAvatar;
use wcf\data\user\avatar\IUserAvatar;
use wcf\system\WCF;
use wcf\util\StringUtil;

class DefaultTourneyAvatar implements IUserAvatar   {
    /**
     * image size
     * @var	integer
     */
    public $size = TeamAvatar::AVATAR_SIZE;

    /**
     * @inheritDoc
     */
    public function getURL($size = null) {
        return WCF::getPath('tourneysystem').'images/tourney/avatars/avatar-default.png';
    }

    /**
     * @inheritDoc
     */
    public function getImageTag($size = null) {
        if ($size === null) $size = $this->size;

        return '<img src="'.StringUtil::encodeHTML($this->getURL($size)).'" style="width: '.$size.'px; height: '.$size.'px" alt="" class="userAvatarImage">';
    }

    /**
     * @inheritDoc
     */
    public function getWidth() {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function getHeight() {
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function canCrop() {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getCropImageTag($size = null) {
        return '';
    }
}