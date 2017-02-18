<?php
/**
 * Created by Trollgon.
 * Date: 01.01.2017
 * Time: 19:46
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\platform\PlatformAction;
use wcf\data\user\option\UserOptionList;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class PlatformAddForm extends AbstractForm {

    /**
     * @see wcf\acp\form\ACPForm::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.platform.add';

    /**
     * @see wcf\page\AbstractPage::$neededPermissions
     */
    public $neededPermissions = array('admin.tourneySystem.canEditPlatforms');

    public $platformID = 0;
    public $platformName = "";
    public $userOption = "";

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['platformName'])) {
            $this->platformName = StringUtil::trim($_POST['platformName']);
        }
        if (isset($_POST['userOption'])) {
            $this->userOption = StringUtil::trim($_POST['userOption']);
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->platformName)) {
            throw new UserInputException('platformName');
        }

        $sql =		"SELECT	COUNT(platformName) AS count
						FROM	tourneysystem1_platform
						WHERE	platformName = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->platformName));
        $row = $statement->fetchArray();

        if ($row['count'] != 0) {
            throw new UserInputException('platformName', 'notUnique');
        }

        if (empty($this->userOption)) {
            throw new UserInputException('userOption');
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'platformName'		=>  $this->platformName,
                'optionID'          =>  $this->userOption,
            ),
        );
        $action = new PlatformAction(array(), 'create', $data);
        $action->executeAction();

        $this->saved();

        WCF::getTPL()->assign('success', true);
    }

    /**
     * @see wcf\form\AbstractForm::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();

        $userOptionArray = new UserOptionList();
        $userOptionArray->getObjects();
        $userOptionArray->readObjects();

        WCF::getTPL()->assign(array(
            'action'            =>  'add',
            'platformName'      =>  $this->platformName,
            'optionID'          =>  $this->userOption,
            'userOptionArray'   =>  $userOptionArray
        ));
    }

}