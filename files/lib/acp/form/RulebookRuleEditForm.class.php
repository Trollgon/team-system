<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 10:33
 */

namespace tourneysystem\acp\form;

use tourneysystem\data\rulebook\article\RulebookArticle;
use tourneysystem\data\rulebook\rule\RulebookRule;
use tourneysystem\data\rulebook\rule\RulebookRuleAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookRuleEditForm extends RulebookRuleAddForm {
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
    public $ruleID = 0;

    /**
     * @var object
     */
    public $rule = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id'])) {
            $this->ruleID = intval($_REQUEST['id']);
        }
        $this->rule = new RulebookRule($this->ruleID);
        if (!$this->rule->ruleID) {
            throw new IllegalLinkException();
        }
        $rulebook = $this->rule->getArticle()->getRulebook();
        if (!WCF::getUser()->getUserID() == $rulebook->creatorID) {
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
                'ruleOrder'		=>  $this->ruleOrder,
                'text'          =>  $this->text,
            ),
        );

        // update page
        $action = new RulebookRuleAction(array($this->ruleID), 'update', $data);
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

        $this->ruleOrder = $this->rule->ruleOrder;
        $this->text = $this->rule->text;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action'            =>  'edit',
            'rule'              =>  $this->rule,
            'ruleOrder'		    =>  $this->ruleOrder,
            'text'              =>  $this->text,
        ));
    }
}