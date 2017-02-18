<?php
/**
 * Created by Trollgon.
 * Date: 08.02.2017
 * Time: 14:16
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\rulebook\article\RulebookArticleAction;
use tourneysystem\data\rulebook\Rulebook;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class RulebookArticleAddForm extends AbstractForm {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.add';

    public $articleOrder = 0;
    public $rulebook = null;
    public $rulebookArticleName = '';
    public $rulebookID = 0;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['rulebookID']))
            $this->rulebookID = intval($_REQUEST['rulebookID']);
        $this->rulebook = new Rulebook($this->rulebookID);
        if (!$this->rulebook->rulebookID) {
            throw new IllegalLinkException();
        }

        if (!WCF::getUser()->getUserID() == $this->rulebook->creatorID) {
            throw new IllegalLinkException();
        }
    }

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['rulebookArticleName'])) {
            $this->rulebookArticleName = StringUtil::trim($_POST['rulebookArticleName']);
        }
        if (isset($_POST['articleOrder'])) {
            $this->articleOrder = StringUtil::trim($_POST['articleOrder']);
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->rulebookArticleName)) {
            throw new UserInputException('rulebookArticleName');
        }

        $sql =		"SELECT	COUNT(rulebookArticleName) AS count
						FROM	tourneysystem1_rulebook_article
						WHERE	rulebookArticleName = ? AND rulebookID = ?";

        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute(array($this->rulebookArticleName, $this->rulebookID));
        $row = $statement->fetchArray();

        if ($row['count'] != 0) {
            throw new UserInputException('rulebookArticleName', 'notUnique');
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'articleOrder'              =>  $this->articleOrder,
                'rulebookArticleName'		=>  $this->rulebookArticleName,
                'rulebookID'                =>  $this->rulebookID
            ),
        );
        $action = new RulebookArticleAction(array(), 'create', $data);
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
            'action'                    =>  'add',
            'articleOrder'              =>  $this->articleOrder,
            'rulebook'                  =>  $this->rulebook,
            'rulebookArticleName'		=>  $this->rulebookArticleName,
        ));
    }
}