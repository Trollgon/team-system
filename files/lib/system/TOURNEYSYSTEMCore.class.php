<?php
namespace tourneysystem\system;
use wcf\system\application\AbstractApplication;
use wcf\system\page\PageLocationManager;

/**
 * Application core.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TOURNEYSYSTEMCore extends AbstractApplication {
	/**
	 * @see	\wcf\system\application\AbstractApplication::$abbreviation
	 */
	protected $abbreviation = 'tourneysystem';
	
	/**
	 * @see \wcf\system\application\AbstractApplication::__run()
	 */
	public function __run() {
		if (!$this->isActiveApplication()) {
			return;
		}

		PageLocationManager::getInstance()->addParentLocation("de.trollgon.tourneysystem.TeamList");
	}
}
