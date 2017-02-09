<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 11:58
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\rulebook\RulebookAction;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class RulebookAddForm extends AbstractForm {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.add';

    public $officialRulebook = 0;
    public $rulebookID = "";
    public $rulebookName = "";

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['rulebookName'])) {
            $this->rulebookName = StringUtil::trim($_POST['rulebookName']);
        }
        if (isset($_POST['officialRulebook'])) {
            $this->officialRulebook = 1;
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->rulebookName)) {
            throw new UserInputException('rulebookName');
        }

        $sql =		"SELECT	COUNT(rulebookName) AS count
						FROM	tourneysystem1_rulebook
						WHERE	rulebookName = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->rulebookName));
        $row = $statement->fetchArray();

        if ($row['count'] != 0) {
            throw new UserInputException('rulebookName', 'notUnique');
        }

        if (!WCF::getSession()->getPermission('admin.tourneySystem.canCreateOfficialRulebooks') && $this->officialRulebook == true) {
            $this->officialRulebook = false;
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'rulebookName'		=>  $this->rulebookName,
                'creatorID'         =>  WCF::getUser()->getUserID(),
                'officialRulebook'  =>  $this->officialRulebook,
            ),
        );
        $action = new RulebookAction(array(), 'create', $data);
        $action->executeAction();

        $this->saved();

        WCF::getTPL()->assign('success', true);
    }

    /**
     * @see wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        WCF::getTPL()->assign(array(
            'action'            =>  'add',
            'rulebookName'      =>  $this->rulebookName,
            'officialRulebook'  =>  $this->officialRulebook,
        ));
    }
}