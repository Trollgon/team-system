<?php
namespace tourneysystem\page;

use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use tourneysystem\data\team\PcTeam;
use tourneysystem\data\team\Ps4Team;
use tourneysystem\data\team\Ps3Team;
use tourneysystem\data\team\Xb1Team;
use tourneysystem\data\team\Xb360Team;

/**
 * Shows the page of a pc team.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */

class TeamPage extends AbstractTeamPage {
	
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'tourneysystem.header.menu.teams';
	
	/**
	 * @see \wcf\page\AbstractPage::show()
	 */
	public function show() {
		if(!WCF::getSession()->getPermission("user.teamSystem.canViewTeamPages")) {
			throw new PermissionDeniedException();
		}
		parent::show();
	}
	
	/**
	 * @see \wcf\page\AbstractPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if(isset($_REQUEST['id']))
			$this->teamID = intval($_REQUEST['id']);
		if(isset($_REQUEST['platformID']))
				$this->platformID = intval($_REQUEST['platformID']);
		if($this->teamID == 0) {
			throw new IllegalLinkException();
		}
		if($this->platformID == 0) {
			throw new IllegalLinkException();
		}
		switch ($this->platformID) {
			case 1:
				$this->team = new PcTeam($this->teamID);
				break;
			case 2:
				$this->team = new Ps4Team($this->teamID);
				break;
			case 3:
				$this->team = new Ps3Team($this->teamID);
				break;
			case 4:
				$this->team = new Xb1Team($this->teamID);
				break;
			case 5:
				$this->team = new Xb360Team($this->teamID);
				break;
		}
		if($this->team->teamID == null || $this->team->teamID == 0) {
			throw new IllegalLinkException();
		}
	}
	
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array(
				'team' 			=> $this->team,
				'teamID'		=> $this->teamID,
				'platformID'	=> $this->platformID,
		));
	}
	
}