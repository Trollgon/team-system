<?php
namespace teamsystem\system;
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
 * @package	de.trollgon.teamsystem
 */
class TEAMSYSTEMCore extends AbstractApplication {
	/**
	 * @see	\wcf\system\application\AbstractApplication::$abbreviation
	 */
	protected $abbreviation = 'teamsystem';
	
	/**
	 * @see \wcf\system\application\AbstractApplication::__run()
	 */
	public function __run() {
		if (!$this->isActiveApplication()) {
			return;
		}
		
		PageMenu::getInstance()->setActiveMenuItem('teamsystem.header.menu.teams');
		WCF::getBreadcrumbs()->add(new Breadcrumb(
			WCF::getLanguage()->get('teamsystem.header.menu.teams'), 
			LinkHandler::getInstance()->getLink('TeamList', array(
				'application' => 'teamsystem'
			))
		));
	}
}
