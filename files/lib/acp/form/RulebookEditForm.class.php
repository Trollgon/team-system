<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 13:27
 */

namespace tourneysystem\acp\form;


use tourneysystem\data\rulebook\Rulebook;
use tourneysystem\data\rulebook\RulebookAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookEditForm extends RulebookAddForm {
    /**
     * @see wcf\acp\form\ACPForm::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.add';

    /**
     * @see wcf\page\AbstractPage::$neededPermissions
     */
    public $neededPermissions = array('admin.tourneySystem.canCreateRulebooks');

    /**
     * @var int
     */
    public $rulebookID = 0;

    /**
     * @var object
     */
    public $rulebook = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id']))
            $this->rulebookID = intval($_REQUEST['id']);
        $this->rulebook = new Rulebook($this->rulebookID);
        if (!$this->rulebook->rulebookID) {
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
                'rulebookName'		=>  $this->rulebookName,
                'officialRulebook'  =>  $this->officialRulebook,
            ),
        );

        // update page
        $action = new RulebookAction(array($this->rulebookID), 'update', $data);
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

        $this->rulebookName = $this->rulebook->rulebookName;
        $this->officialRulebook = $this->rulebook->officialRulebook;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action'            =>  'edit',
            'rulebook'          =>  $this->rulebook,
            'officialRulebook'  =>  $this->officialRulebook,
        ));
    }
}