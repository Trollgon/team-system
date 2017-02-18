<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 11:32
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\gamemode\GamemodeAction;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class GamemodeAddForm extends AbstractForm {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.gamemode.add';

    public $gamemodeID = "";
    public $gamemodeName = "";

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['gamemodeName'])) {
            $this->gamemodeName = StringUtil::trim($_POST['gamemodeName']);
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->gamemodeName)) {
            throw new UserInputException('gamemodeName');
        }

        $sql =		"SELECT	COUNT(gamemodeName) AS count
						FROM	tourneysystem1_gamemode
						WHERE	gamemodeName = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->gamemodeName));
        $row = $statement->fetchArray();

        if ($row['count'] != 0) {
            throw new UserInputException('gamemodeName', 'notUnique');
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'gamemodeName'		=>  $this->gamemodeName,
            ),
        );
        $action = new GamemodeAction(array(), 'create', $data);
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
            'gamemodeName'      =>  $this->gamemodeName,
        ));
    }
}