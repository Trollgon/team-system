<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 10:33
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\rulebook\article\RulebookArticle;
use tourneysystem\data\rulebook\rule\RulebookRuleAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class RulebookRuleAddForm extends AbstractForm {

    public $activeMenuItem = 'wcf.acp.menu.link.tourneysystem.rulebook.add';

    public $rulebookArticleID = 0;
    public $rulebookArticle = null;
    public $ruleOrder = 0;
    public $text = '';

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['rulebookArticleID']))
            $this->rulebookArticleID = intval($_REQUEST['rulebookArticleID']);
        $this->rulebookArticle = new RulebookArticle($this->rulebookArticleID);
        if (!$this->rulebookArticle->rulebookArticleID) {
            throw new IllegalLinkException();
        }

        if (!WCF::getUser()->getUserID() == $this->rulebookArticle->getRulebook()->creatorID) {
            throw new IllegalLinkException();
        }
    }

    /**
     * @see wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['ruleOrder'])) {
            $this->ruleOrder = StringUtil::trim($_POST['ruleOrder']);
        }
        if (isset($_POST['text'])) {
            $this->text = StringUtil::trim($_POST['text']);
        }
    }

    /**
     * @see wcf\form\AbstractForm::valdiate()
     */
    public function validate() {
        parent::validate();

        if (empty($this->text)) {
            throw new UserInputException('text');
        }
    }

    /**
     * @see wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();

        $data = array(
            'data' => array(
                'articleID'     =>  $this->rulebookArticleID,
                'ruleOrder'		=>  $this->ruleOrder,
                'text'          =>  $this->text,
            ),
        );
        $action = new RulebookRuleAction(array(), 'create', $data);
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
            'action'                =>  'add',
            'article'               =>  $this->rulebookArticle,
            'ruleOrder'             =>  $this->ruleOrder,
            'text'              	=>  $this->text,
        ));
    }
}