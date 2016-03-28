<?php
namespace tourneysystem\page;
use wcf\page\AbstractPage;

/**
 * Shows the index page.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TourneysPage extends AbstractPage { 
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */

	public $activeMenuItem = 'tourneysystem.header.menu.tourneys';
	
}
