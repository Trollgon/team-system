<?php
/**
 * Created by Trollgon.
 * Date: 06.02.2017
 * Time: 13:38
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\game\GameAction;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class GameAddForm extends AbstractForm {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.game.add';

    public $gameID = "";
    public $gameName = "";

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['gameName'])) {
            $this->gameName = StringUtil::trim($_POST['gameName']);
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->gameName)) {
            throw new UserInputException('gameName');
        }

        $sql =		"SELECT	COUNT(gameName) AS count
						FROM	tourneysystem1_game
						WHERE	gameName = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->gameName));
        $row = $statement->fetchArray();

        if ($row['count'] != 0) {
            throw new UserInputException('gameName', 'notUnique');
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'gameName'		=>  $this->gameName,
            ),
        );
        $action = new GameAction(array(), 'create', $data);
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
            'action'        =>  'add',
            'gameName'      =>  $this->gameName,
        ));
    }
}