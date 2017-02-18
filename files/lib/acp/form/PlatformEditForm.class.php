<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 13:18
 */

namespace tourneysystem\acp\form;


use tourneysystem\data\platform\Platform;
use tourneysystem\data\platform\PlatformAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class PlatformEditForm extends PlatformAddForm  {

    /**
     * @see wcf\acp\form\ACPForm::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.platform.add';

    /**
     * @see wcf\page\AbstractPage::$neededPermissions
     */
    public $neededPermissions = array('admin.tourneySystem.canEditPlatforms');

    /**
     * @var int
     */
    public $platformID = 0;

    /**
     * @var object
     */
    public $platform = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id']))
            $this->platformID = intval($_REQUEST['id']);
        $this->platform = new Platform($this->platformID);
        if (!$this->platform->platformID) {
            throw new IllegalLinkException();
        }
    }

    /**
     * @see wcf\form\IForm::save()
     */
    public function save() {
        AbstractForm::save();

        $data = array(
            'data' => array(
                'platformName'		=>  $this->platformName,
                'optionID'          =>  $this->userOption,
            ),
        );

        // update page
        $action = new PlatformAction(array($this->platformID), 'update', $data);
        $action->executeAction();

        $this->saved();

        // show success
        WCF::getTPL()->assign(array(
            'success' => true
        ));
    }

    /**
     * @see wcf\page\IPage::readData()
     */
    public function readData() {
        parent::readData();

        $this->platformName = $this->platform->platformName;
        $this->userOption = $this->platform->optionID;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action'    =>  'edit',
            'optionID'  =>  $this->userOption,
            'platform'  =>  $this->platform,
        ));
    }
}