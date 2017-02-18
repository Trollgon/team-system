/**
 * Initialize the TOURNEYSYSTEM namespace
 */
var TOURNEYSYSTEM = {};

/**
 * Namespace for team functions.
 */
TOURNEYSYSTEM.Team = {};

/**
 * Namespace for avatar functions.
 */
TOURNEYSYSTEM.Team.Avatar = {};

/**
 * Avatar upload function
 *
 * @see	WCF.Upload
 */
TOURNEYSYSTEM.Team.Avatar.Upload = WCF.Upload.extend({
	/**
	 * team id of avatar owner
	 * @var	integer
	 */
	_teamID: 0,

	/**
	 * Initalizes a new TOURNEYSYSTEM.Avatar.Upload object.
	 *
	 * @param	integer			teamID
	 */
	init: function(teamID) {
		this._super($('#avatarUpload > dd > div'), undefined, 'tourneysystem\\data\\team\\avatar\\TeamAvatarAction');
		this._teamID = teamID || 0;

		$('#avatarForm input[type=radio]').change(function() {
			if ($(this).val() == 'custom') {
				$('#avatarUpload > dd > div').show();
			}
			else {
				$('#avatarUpload > dd > div').hide();
			}
		});
		if (!$('#avatarForm input[type=radio][value=custom]:checked').length) {
			$('#avatarUpload > dd > div').hide();
		}
	},

	/**
	 * @see	WCF.Upload._initFile()
	 */
	_initFile: function(file) {
		return $('#avatarUpload > dt > img');
	},

	/**
	 * @see	WCF.Upload._success()
	 */
	_success: function(uploadID, data) {
		if (data.returnValues.url) {
			this._updateImage(data.returnValues.url);

			// hide error
			$('#avatarUpload > dd > .innerError').remove();

			// show success message
			var $notification = new WCF.System.Notification(WCF.Language.get('wcf.user.avatar.upload.success'));
			$notification.show();
		}
		else if (data.returnValues.errorType) {
			// show error
			this._getInnerErrorElement().text(WCF.Language.get('wcf.user.avatar.upload.error.' + data.returnValues.errorType));
		}
	},

	/**
	 * Updates the displayed avatar image.
	 *
	 * @param	string		url
	 */
	_updateImage: function(url) {
		$('#avatarUpload > dt > img').remove();
		var $image = $('<img src="' + url + '" class="userAvatarImage" alt="" />').css({
			'height': 'auto',
			'max-height': '96px',
			'max-width': '96px',
			'width': 'auto'
		});

		$('#avatarUpload > dt').prepend($image);

		WCF.DOMNodeInsertedHandler.execute();
	},

	/**
	 * Returns the inner error element.
	 *
	 * @return	jQuery
	 */
	_getInnerErrorElement: function() {
		var $span = $('#avatarUpload > dd > .innerError');
		if (!$span.length) {
			$span = $('<small class="innerError"></span>');
			$('#avatarUpload > dd').append($span);
		}

		return $span;
	},

	/**
	 * @see	WCF.Upload._getParameters()
	 */
	_getParameters: function() {
		return {
			teamID: this._teamID
		};
	}
});