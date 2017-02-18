<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 13:27
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\gamemode\Gamemode;
use tourneysystem\data\gamemode\GamemodeAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class GamemodeEditForm extends GamemodeAddForm {
    /**
     * @see wcf\acp\form\ACPForm::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.gamemode.add';

    /**
     * @see wcf\page\AbstractPage::$neededPermissions
     */
    public $neededPermissions = array('admin.tourneySystem.canEditGamemodes');

    /**
     * @var int
     */
    public $gamemodeID = 0;

    /**
     * @var object
     */
    public $gamemode = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id']))
            $this->gamemodeID = intval($_REQUEST['id']);
        $this->gamemode = new Gamemode($this->gamemodeID);
        if (!$this->gamemode->gamemodeID) {
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
                'gamemodeName'		=>  $this->gamemodeName,
            ),
        );

        // update page
        $action = new GamemodeAction(array($this->gamemodeID), 'update', $data);
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

        $this->gamemodeName = $this->gamemode->gamemodeName;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action'    => 'edit',
            'gamemode'  =>  $this->gamemode,
        ));
    }
}