<?php
namespace teamsystem\data\team\avatar;
use wcf\data\user\User;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\SystemException;
use wcf\system\exception\UserInputException;
use wcf\system\image\ImageHandler;
use wcf\system\upload\AvatarUploadFileValidationStrategy;
use wcf\system\WCF;
use wcf\util\FileUtil;
use wcf\util\HTTPRequest;use teamsystem\data\team\Team;use teamsystem\data\team\TeamEditor;use teamsystem\data\team\avatar\TeamAvatarEditor;

/**
 * Executes avatar-related actions.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2015 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf
 * @subpackage	data.user.avatar
 * @category	Community Framework
 */
class TeamAvatarAction extends AbstractDatabaseObjectAction {
	/**
	 * currently edited avatar
	 * @var	\teamsystem\data\team\avatar\TeamAvatarEditor
	 */		/**	 * @see	\wcf\data\AbstractDatabaseObjectAction::$className	 */	public $className = 'teamsystem\data\team\avatar\TeamAvatarEditor';
	public $avatar = null;	public $team = null;		public function getDatabaseTableIndexName() {		return TeamAvatar::getDatabaseTableIndexName();	}
	
	/**
	 * Validates the upload action.
	 */
	public function validateUpload() {
		$this->readInteger('teamID', true);
		
		if ($this->parameters['teamID']) {
			$this->team = new Team($this->parameters['teamID']);
			if (!$team->teamID) {
				throw new IllegalLinkException();
			}
		}
		
		if (count($this->parameters['__files']->getFiles()) != 1) {
			throw new UserInputException('files');
		}
		
		// check max filesize, allowed file extensions etc.
		$this->parameters['__files']->validateFiles(new AvatarUploadFileValidationStrategy(PHP_INT_MAX, explode("\n", WCF::getSession()->getPermission('user.profile.avatar.allowedFileExtensions'))));
	}
	
	/**
	 * Handles uploaded attachments.
	 */
	public function upload() {
		// save files
		$files = $this->parameters['__files']->getFiles();				$this->teamID = $this->team->teamID;				$team = new Team($this->team->teamID);
		$file = $files[0];
		
		try {
			if (!$file->getValidationErrorType()) {
				// shrink avatar if necessary
				$fileLocation = $this->enforceDimensions($file->getLocation());
				$imageData = getimagesize($fileLocation);
				
				$data = array(
					'avatarName' => $file->getFilename(),
					'avatarExtension' => $file->getFileExtension(),
					'width' => $imageData[0],
					'height' => $imageData[1],
					'teamID' => $teamID,
					'fileHash' => sha1_file($fileLocation)
				);
				
				// create avatar
				$avatar = TeamAvatarEditor::create($data);
				
				// check avatar directory
				// and create subdirectory if necessary
				$dir = dirname($avatar->getLocation());
				if (!@file_exists($dir)) {
					FileUtil::makePath($dir, 0777);
				}
				
				// move uploaded file
				if (@copy($fileLocation, $avatar->getLocation())) {
					@unlink($fileLocation);
					
					// create thumbnails
					$action = new TeamAvatarAction(array($avatar), 'generateThumbnails');
					$action->executeAction();
					
					// delete old avatar
					if ($this->team->avatarID) {
						$action = new TeamAvatarAction(array($this->team->avatarID), 'delete');
						$action->executeAction();
					}
					
					// update team
					$teamEditor = new TeamEditor($this->team->teamID);
					$teamEditor->update(array(
						'avatarID' => $avatar->avatarID,
					));
					
					// reset user storage
					// UserStorageHandler::getInstance()->reset(array($userID), 'avatar');
					
					// return result
					return array(
						'avatarID' => $avatar->avatarID,
						'canCrop' => $avatar->canCrop(),
						'url' => $avatar->getURL(96)
					);
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
		
		return array('errorType' => $file->getValidationErrorType());
	}
	
	/**
	 * Generates the thumbnails of the avatars in all needed sizes.
	 */
	public function generateThumbnails() {
		if (empty($this->objects)) {
			$this->readObjects();
		}
		
		foreach ($this->objects as $avatar) {
			$adapter = ImageHandler::getInstance()->getAdapter();
			$adapter->loadFile($avatar->getLocation());
			
			foreach (TeamAvatar::$avatarThumbnailSizes as $size) {
				if ($avatar->width <= $size && $avatar->height <= $size) break 2;
				
				$thumbnail = $adapter->createThumbnail($size, $size, false);
				$adapter->writeImage($thumbnail, $avatar->getLocation($size));
			}
		}
	}
	
	/**
	 * Fetches an avatar from a remote server and sets it for given user.
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
		
		$data = array(
			'avatarName' => $tmp['basename'],
			'avatarExtension' => $tmp['extension'],
			'width' => $imageData[0],
			'height' => $imageData[1],
			'teamID' => $this->team->teamID,
			'fileHash' => sha1_file($filename)
		);
		
		// create avatar
		$avatar = TeamAvatarEditor::create($data);
		
		// check avatar directory
		// and create subdirectory if necessary
		$dir = dirname($avatar->getLocation());
		if (!@file_exists($dir)) {
			FileUtil::makePath($dir, 0777);
		}
		
		// move uploaded file
		if (@copy($filename, $avatar->getLocation())) {
			@unlink($filename);
			
			// create thumbnails
			$action = new TeamAvatarAction(array($avatar), 'generateThumbnails');
			$action->executeAction();
			
			$avatarID = $avatar->avatarID;
		}
		else {
			@unlink($filename);
			
			// moving failed; delete avatar
			$editor = new TeamAvatarEditor($avatar);
			$editor->delete();
		}
		
		// update user
		if ($avatarID) {
			$this->parameters['TeamEditor']->update(array(
				'avatarID' => $avatarID,
			));
			
			// delete old avatar
			if ($this->parameters['TeamEditor']->avatarID) {
				$action = new TeamAvatarAction(array($this->parameters['TeamEditor']->avatarID), 'delete');
				$action->executeAction();
			}
		}
		
		// reset user storage
		// UserStorageHandler::getInstance()->reset(array($this->parameters['userEditor']->userID), 'avatar');
	}
	
	/**
	 * Enforces dimensions for given avatar.
	 * 
	 * @param	string		$filename
	 * @return	string
	 */
	protected function enforceDimensions($filename) {
		$imageData = getimagesize($filename);
		if ($imageData[0] > MAX_AVATAR_WIDTH || $imageData[1] > MAX_AVATAR_HEIGHT) {
			try {
				$obtainDimensions = true;
				if (MAX_AVATAR_WIDTH / $imageData[0] < MAX_AVATAR_HEIGHT / $imageData[1]) {
					if (round($imageData[1] * (MAX_AVATAR_WIDTH / $imageData[0])) < 48) $obtainDimensions = false;
				}
				else {
					if (round($imageData[0] * (MAX_AVATAR_HEIGHT / $imageData[1])) < 48) $obtainDimensions = false;
				}
				
				$adapter = ImageHandler::getInstance()->getAdapter();
				$adapter->loadFile($filename);
				$filename = FileUtil::getTemporaryFilename();
				$thumbnail = $adapter->createThumbnail(MAX_AVATAR_WIDTH, MAX_AVATAR_HEIGHT, $obtainDimensions);
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
	
	/**
	 * Validates the 'getCropDialog' action.
	 */
	public function validateGetCropDialog() {
		$this->avatar = $this->getSingleObject();
	}
	
	/**
	 * Returns the data for the dialog to crop an avatar.
	 * 
	 * @return	array
	 */
	public function getCropDialog() {
		return array(
			'cropX' => $this->avatar->cropX,
			'cropY' => $this->avatar->cropY,
			'template' => WCF::getTPL()->fetch('avatarCropDialog', 'wcf', array(
				'avatar' => $this->avatar
			))
		);
	}
	
	/**
	 * Validates the 'cropAvatar' action.
	 */
	public function validateCropAvatar() {
		$this->avatar = $this->getSingleObject();
		
		// check if user can edit the given avatar				$teamcheck = new Team($this->avatar->teamID);
		if ($teamcheck->getLeaderID() != WCF::getUser()->userID) {
			throw new PermissionDeniedException();
		}	
		// check parameters
		$this->readInteger('cropX', true);
		$this->readInteger('cropY', true);
		
		if ($this->parameters['cropX'] < 0 || $this->parameters['cropX'] > $this->avatar->width - TeamAvatar::$maxThumbnailSize) {
			throw new UserInputException('cropX');
		}
		if ($this->parameters['cropY'] < 0 || $this->parameters['cropY'] > $this->avatar->height - TeamAvatar::$maxThumbnailSize) {
			throw new UserInputException('cropY');
		}
	}
	
	/**
	 * Craps an avatar.
	 */
	public function cropAvatar() {
		// created clipped avatar as base for new thumbnails
		$adapter = ImageHandler::getInstance()->getAdapter();
		$adapter->loadFile($this->avatar->getLocation());
		$adapter->clip($this->parameters['cropX'], $this->parameters['cropY'], TeamAvatar::$maxThumbnailSize, TeamAvatar::$maxThumbnailSize);
		
		// update thumbnails
		foreach (TeamAvatar::$avatarThumbnailSizes as $size) {
			$thumbnail = $adapter->createThumbnail($size, $size);
			$adapter->writeImage($thumbnail, $this->avatar->getLocation($size));
		}
		
		// update database entry
		$this->avatar->update(array(
			'cropX' => $this->parameters['cropX'],
			'cropY' => $this->parameters['cropY']
		));
		
		return array(
			'url' => $this->avatar->getURL(96)
		);
	}
}
