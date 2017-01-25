<?php
namespace tourneysystem\data\team\avatar;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamEditor;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\SystemException;
use wcf\system\exception\UserInputException;
use wcf\system\image\ImageHandler;
use wcf\system\upload\AvatarUploadFileValidationStrategy;
use wcf\system\upload\UploadFile;
use wcf\system\WCF;
use wcf\util\FileUtil;
use wcf\util\HTTPRequest;

/**
 * Class TeamAvatarAction
 * @package tourneysystem\data\team\avatar
 */
class TeamAvatarAction extends AbstractDatabaseObjectAction {
    /**
     * currently edited avatar
     * @var	TeamAvatarEditor
     */
    public $avatar = null;

    /**
     * Validates the upload action.
     */
    public function validateUpload() {
        $this->readInteger('teamID', true);

        if ($this->parameters['teamID']) {
            $team = new Team($this->parameters['teamID']);
            if (!$team->teamID) {
                throw new IllegalLinkException();
            }
        }

        /** @noinspection PhpUndefinedMethodInspection */
        if (count($this->parameters['__files']->getFiles()) != 1) {
            throw new UserInputException('files');
        }

        // check max filesize, allowed file extensions etc.
        /** @noinspection PhpUndefinedMethodInspection */
        $this->parameters['__files']->validateFiles(new AvatarUploadFileValidationStrategy(PHP_INT_MAX, explode("\n", WCF::getSession()->getPermission('team.profile.avatar.allowedFileExtensions'))));
    }

    /**
     * Handles uploaded attachments.
     */
    public function upload() {
        /** @var UploadFile[] $files */
        /** @noinspection PhpUndefinedMethodInspection */
        $files = $this->parameters['__files']->getFiles();
        $teamID = intval($this->parameters['teamID']);
        $team = new Team($teamID);
        $file = $files[0];

        try {
            if (!$file->getValidationErrorType()) {
                // shrink avatar if necessary
                $fileLocation = $this->enforceDimensions($file->getLocation());
                $imageData = getimagesize($fileLocation);

                $data = [
                    'avatarName' => $file->getFilename(),
                    'avatarExtension' => $file->getFileExtension(),
                    'width' => $imageData[0],
                    'height' => $imageData[1],
                    'teamID' => $teamID,
                    'fileHash' => sha1_file($fileLocation)
                ];

                // create avatar
                $avatar = TeamAvatarEditor::create($data);

                // check avatar directory
                // and create subdirectory if necessary
                $dir = dirname($avatar->getLocation());
                if (!@file_exists($dir)) {
                    FileUtil::makePath($dir);
                }

                // move uploaded file
                if (@copy($fileLocation, $avatar->getLocation())) {
                    @unlink($fileLocation);

                    // delete old avatar
                    if ($team->avatarID) {
                        $action = new TeamAvatarAction([$team->avatarID], 'delete');
                        $action->executeAction();
                    }

                    // update team
                    $teamEditor = new TeamEditor($team);
                    $teamEditor->update([
                        'avatarID' => $avatar->avatarID,
                    ]);

                    // return result
                    return [
                        'avatarID' => $avatar->avatarID,
                        'url' => $avatar->getURL(96)
                    ];
                }
                else {
                    // moving failed; delete avatar
                    $editor = new TeamAvatarEditor($avatar);
                    $editor->delete();
                    throw new UserInputException('avatar', 'uploadFailed');
                }
            }
        }
        catch (UserInputException $e) {
            $file->setValidationErrorType($e->getType());
        }

        return ['errorType' => $file->getValidationErrorType()];
    }

    /**
     * Fetches an avatar from a remote server and sets it for given team.
     */
    public function fetchRemoteAvatar() {
        $avatarID = 0;
        $filename = '';

        // fetch avatar from URL
        try {
            $request = new HTTPRequest($this->parameters['url']);
            $request->execute();
            $reply = $request->getReply();
            $filename = FileUtil::getTemporaryFilename('avatar_');
            file_put_contents($filename, $reply['body']);

            $imageData = getimagesize($filename);
            if ($imageData === false) throw new SystemException('Downloaded file is not an image');
        }
        catch (\Exception $e) {
            if (!empty($filename)) {
                @unlink($filename);
            }
            return;
        }

        // rescale avatar if required
        try {
            $newFilename = $this->enforceDimensions($filename);
            if ($newFilename !== $filename) @unlink($filename);
            $filename = $newFilename;

            $imageData = getimagesize($filename);
            if ($imageData === false) throw new SystemException('Rescaled file is not an image');
        }
        catch (\Exception $e) {
            @unlink($filename);
            return;
        }

        $tmp = parse_url($this->parameters['url']);
        if (!isset($tmp['path'])) {
            @unlink($filename);
            return;
        }
        $tmp = pathinfo($tmp['path']);
        if (!isset($tmp['basename']) || !isset($tmp['extension'])) {
            @unlink($filename);
            return;
        }

        $data = [
            'avatarName' => $tmp['basename'],
            'avatarExtension' => $tmp['extension'],
            'width' => $imageData[0],
            'height' => $imageData[1],
            'teamID' => $this->parameters['teamEditor']->teamID,
            'fileHash' => sha1_file($filename)
        ];

        // create avatar
        $avatar = TeamAvatarEditor::create($data);

        // check avatar directory
        // and create subdirectory if necessary
        $dir = dirname($avatar->getLocation());
        if (!@file_exists($dir)) {
            FileUtil::makePath($dir);
        }

        // move uploaded file
        if (@copy($filename, $avatar->getLocation())) {
            @unlink($filename);

            $avatarID = $avatar->avatarID;
        }
        else {
            @unlink($filename);

            // moving failed; delete avatar
            $editor = new TeamAvatarEditor($avatar);
            $editor->delete();
        }

        // update team
        if ($avatarID) {
            /** @var TeamEditor $teamEditor */
            $teamEditor = $this->parameters['teamEditor'];

            $teamEditor->update([
                'avatarID' => $avatarID,
            ]);

            // delete old avatar
            if ($teamEditor->avatarID) {
                $action = new TeamAvatarAction([$teamEditor->avatarID], 'delete');
                $action->executeAction();
            }
        }
    }

    /**
     * Enforces dimensions for given avatar.
     *
     * @param	string		$filename
     * @return	string
     * @throws	UserInputException
     */
    protected function enforceDimensions($filename) {
        $imageData = getimagesize($filename);
        if ($imageData[0] > TeamAvatar::AVATAR_SIZE || $imageData[1] > TeamAvatar::AVATAR_SIZE) {
            try {
                $adapter = ImageHandler::getInstance()->getAdapter();
                $adapter->loadFile($filename);
                $filename = FileUtil::getTemporaryFilename();
                $thumbnail = $adapter->createThumbnail(TeamAvatar::AVATAR_SIZE, TeamAvatar::AVATAR_SIZE, false);
                $adapter->writeImage($thumbnail, $filename);
            }
            catch (SystemException $e) {
                throw new UserInputException('avatar', 'tooLarge');
            }

            // check filesize (after shrink)
            if (@filesize($filename) > WCF::getSession()->getPermission('user.profile.avatar.maxSize')) {
                throw new UserInputException('avatar', 'tooLarge');
            }
        }

        return $filename;
    }
}
