<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 13:26
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\game\Game;
use tourneysystem\data\game\GameAction;
use wcf\form\AbstractForm;
use wcf\page\AbstractPage;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class GameEditForm extends GameAddForm {

    /**
     * @see wcf\acp\form\ACPForm::$activeMenuItem
     */
    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.game.add';

    /**
     * @see wcf\page\AbstractPage::$neededPermissions
     */
    public $neededPermissions = array('admin.tourneySystem.canEditGames');

    /**
     * @var int
     */
    public $gameID = 0;

    /**
     * @var object
     */
    public $game = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id']))
            $this->gameID = intval($_REQUEST['id']);
        $this->game = new Game($this->gameID);
        if (!$this->game->gameID) {
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
                'gameName'		=>  $this->gameName,
            ),
        );

        // update page
        $action = new GameAction(array($this->gameID), 'update', $data);
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

        $this->gameName = $this->game->gameName;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action' => 'edit',
            'game'   => $this->game,
        ));
    }
}