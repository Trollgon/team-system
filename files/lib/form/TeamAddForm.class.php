<?php
namespace tourneysystem\form;
use tourneysystem\data\team\Team;
use tourneysystem\data\team\TeamAction;
use tourneysystem\data\team\TeamEditor;
use tourneysystem\util\TeamUtil;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\WCF;
use wcf\util\HeaderUtil;
use wcf\util\StringUtil;
use wcf\system\exception\UserInputException;
use wcf\system\request\LinkHandler;

/**
 * Shows the index page.
 *
 * @author	Trollgon
 * @copyright	Trollgon
 * @license	GNU Lesser General Public License <http://www.gnu.org/licenses/lgpl-3.0.txt>
 * @package	de.trollgon.tourneysystem
 */
class TeamAddForm extends AbstractForm {

	public  $formData = array(
			'teamName' => '',
			'teamTag' => '',
			'leaderID' => '',
			'leaderName' => ''
		);
		public function readFormParameters() {
			parent::readFormParameters();
			if (isset($_POST['teamName'])) {
				$this->formData['teamName'] = StringUtil::trim($_POST['teamName']);
			}
			if (isset($_POST['teamTag'])) {
				$this->formData['teamTag'] = StringUtil::trim($_POST['teamTag']);
			}
			$this->formData['leaderID'] =  WCF::getUser()->userID;
			$this->formData['leaderName'] = WCF::getUser()->username;
	}
	
/**
		public function validate() {
			parent::validate();
			if ($this->formData['eventName'] == "") {
				throw new UserInputException('eventName', 'empty');
			}
	}
**/
	
	public function save() {
			parent::save();
			
			$data = array(
				'data' => array(
					'teamName'		=> $this->formData['teamName'], 
					'teamTag'		=> $this->formData['teamTag'], 
					'leaderID'		=> $this->formData['leaderID'],
					'leaderName'	=> $this->formData['leaderName'],
					
				),
			);
			
			$action = new TeamAction(array(), 'create', $data);
			$action->executeAction();  
			HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Index', array(
				'application' => 'tourneysystem'
			)),WCF::getLanguage()->get('tourneysystem.team.add.successfulRedirect'), 10);
			exit;
	}
	
		public function assignVariables() {
			parent::assignVariables();
			WCF::getTPL()->assign(array(
				'formData' => $this->formData
			));
	}

}
