<?php
namespace tourneysystem\system;
use wcf\system\application\AbstractApplication;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\menu\page\PageMenu;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

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
		
		PageMenu::getInstance()->setActiveMenuItem('tourneysystem.header.menu.tourneys');
		WCF::getBreadcrumbs()->add(new Breadcrumb(
			WCF::getLanguage()->get('tourneysystem.header.menu.tourneys'), 
			LinkHandler::getInstance()->getLink('Tourneys', array(
				'application' => 'tourneysystem'
			))
		));
	}
}
