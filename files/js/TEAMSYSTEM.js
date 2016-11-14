/**
 * Initialize the TEAMSYSTEM namespace
 */
var TEAMSYSTEM = {};


/**
 * Initialize the TEAMSYSTEM namespace
 */
TEAMSYSTEM.Avatar = {};


/**

 * Avatar upload function

 * 

 * @see	WCF.Upload

 */

TEAMSYSTEM.Avatar.Upload = WCF.Upload.extend({

	/**

	 * handles cropping the avatar

	 * @var	WCF.User.Avatar.Crop

	 */

	_avatarCrop: null,

	

	/**

	 * team id of avatar owner

	 * @var	integer

	 */

	_teamID: 0,

	

	/**

	 * Initalizes a new TEAMSYSTEM.Avatar.Upload  object.

	 * 

	 * @param	integer			teamID

	 * @param	WCF.User.Avatar.Crop	avatarCrop

	 */

	init: function(teamID, avatarCrop) {
		

		this._super($('#avatarUpload > dd > div'), undefined, 'teamsystem\\data\\team\\avatar\\TeamAvatarAction');

		this._teamID = teamID || 0;

		this._avatarCrop = avatarCrop;

		

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

			this._updateImage(data.returnValues.url, data.returnValues.canCrop);

			

			if (data.returnValues.canCrop) {

				if (!this._avatarCrop) {

					this._avatarCrop = new TEAMSYSTEM.Avatar.Crop(data.returnValues.avatarID);

				}

				else {

					this._avatarCrop.init(data.returnValues.avatarID);

				}

			}

			else if (this._avatarCrop) {

				this._avatarCrop.destroy();

				this._avatarCrop = null;

			}

			

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

	 * @param	boolean		canCrop

	 */

	_updateImage: function(url, canCrop) {

		$('#avatarUpload > dt > img').remove();

		var $image = $('<img src="' + url + '" alt="" />').css({

			'height': 'auto',

			'max-height': '96px',

			'max-width': '96px',

			'width': 'auto'

		});

		if (canCrop) {

			$image.addClass('teamAvatarCrop').addClass('jsTooltip');

			$image.attr('title', WCF.Language.get('wcf.user.avatar.type.custom.crop'));

		}

		

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

	},

});


/**

 * Handles cropping an avatar.

 */

TEAMSYSTEM.Avatar.Crop = Class.extend({

	/**

	 * current crop setting in x-direction

	 * @var	integer

	 */

	_cropX: 0,

	

	/**

	 * current crop setting in y-direction

	 * @var	integer

	 */

	_cropY: 0,

	

	/**

	 * avatar crop dialog

	 * @var	jQuery

	 */

	_dialog: null,

	

	/**

	 * action proxy to send the crop AJAX requests

	 * @var	WCF.Action.Proxy

	 */

	_proxy: null,

	

	/**

	 * maximum size of thumbnails

	 * @var	integer

	 */

	MAX_THUMBNAIL_SIZE: 128,

	

	/**

	 * Creates a new instance of WCF.User.Avatar.Crop.

	 * 

	 * @param	integer		avatarID

	 */

	init: function(avatarID) {

		this._avatarID = avatarID;

		

		if (this._dialog) {

			this.destroy();

		}

		this._dialog = null;

		

		// check if object already had been initialized

		if (!this._proxy) {

			this._proxy = new WCF.Action.Proxy({

				success: $.proxy(this._success, this)

			});

		}

		

		$('.teamAvatarCrop').click($.proxy(this._showCropDialog, this));

	},

	

	/**

	 * Destroys the avatar crop interface.

	 */

	destroy: function() {

		this._dialog.remove();

	},

	

	/**

	 * Sends AJAX request to crop avatar.

	 * 

	 * @param	object		event

	 */

	_crop: function(event) {

		this._proxy.setOption('data', {

			actionName: 'cropAvatar',

			className: 'teamsystem\\data\\team\\avatar\\TeamAvatarAction',

			objectIDs: [ this._avatarID ],

			parameters: {

				cropX: this._cropX,

				cropY: this._cropY

			}

		});

		this._proxy.sendRequest();

	},

	

	/**

	 * Initializes the dialog after a successful 'getCropDialog' request.

	 * 

	 * @param	object		data

	 */

	_getCropDialog: function(data) {

		if (!this._dialog) {

			this._dialog = $('<div />').hide().appendTo(document.body);

			this._dialog.wcfDialog({

				title: WCF.Language.get('wcf.user.avatar.type.custom.crop')

			});

		}

		

		this._dialog.html(data.returnValues.template);

		this._dialog.find('button[data-type="save"]').click($.proxy(this._crop, this));

		

		this._cropX = data.returnValues.cropX;

		this._cropY = data.returnValues.cropY;

		

		var $image = $('#teamAvatarCropSelection > img');

		$('#teamAvatarCropSelection').css({

			height: $image.height() + 'px',

			width: $image.width() + 'px'

		});

		$('#teamAvatarCropOverlaySelection').css({

			'background-image': 'url(' + $image.attr('src') + ')',

			'background-position': -this._cropX + 'px ' + -this._cropY + 'px',

			'left': this._cropX + 'px',

			'top': this._cropY + 'px'

		}).draggable({

			containment: 'parent',

			drag : $.proxy(this._updateSelection, this),

			stop : $.proxy(this._updateSelection, this)

		});

		

		this._dialog.find('button[data-type="save"]').click($.proxy(this._save, this));

		

		this._dialog.wcfDialog('render');

	},

	

	/**

	 * Shows the cropping dialog.

	 */

	_showCropDialog: function() {

		if (!this._dialog) {

			this._proxy.setOption('data', {

				actionName: 'getCropDialog',

				className: 'teamsystem\\data\\team\\avatar\\TeamAvatarAction',

				objectIDs: [ this._avatarID ]

			});

			this._proxy.sendRequest();

		}

		else {

			this._dialog.wcfDialog('open');

		}

	},

	

	/**

	 * Handles successful AJAX request.

	 * 

	 * @param	object		data

	 * @param	string		textStatus

	 * @param	jQuery		jqXHR

	 */

	_success: function(data, textStatus, jqXHR) {

		switch (data.actionName) {

			case 'getCropDialog':

				this._getCropDialog(data);

			break;

			

			case 'cropAvatar':

				$('#avatarUpload > dt > img').replaceWith($('<img src="' + data.returnValues.url + '" alt="" class="teamAvatarCrop jsTooltip" title="' + WCF.Language.get('wcf.user.avatar.type.custom.crop') + '" />').css({

					width: '96px',

					height: '96px'

				}).click($.proxy(this._showCropDialog, this)));

				

				WCF.DOMNodeInsertedHandler.execute();

				

				this._dialog.wcfDialog('close');

				

				var $notification = new WCF.System.Notification();

				$notification.show();

			break;

		}

	},

	

	/**

	 * Updates the current crop selection if the selection overlay is dragged.

	 * 

	 * @param	object		event

	 * @param	object		ui

	 */

	_updateSelection: function(event, ui) {

		this._cropX = ui.position.left;

		this._cropY = ui.position.top;

		

		$('#teamAvatarCropOverlaySelection').css({

			'background-position': -ui.position.left + 'px ' + -ui.position.top + 'px'

		});

	}

});