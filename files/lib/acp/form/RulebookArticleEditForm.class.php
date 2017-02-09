<?php
/**
 * Created by Trollgon.
 * Date: 09.02.2017
 * Time: 10:32
 */

namespace tourneysystem\acp\form;


use tourneysystem\data\rulebook\article\RulebookArticle;
use tourneysystem\data\rulebook\article\RulebookArticleAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class RulebookArticleEditForm extends RulebookArticleAddForm {
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
    public $rulebookArticleID = 0;

    /**
     * @var object
     */
    public $rulebookArticle = null;

    /**
     * @see wcf\page\IPage::readParameters()
     */
    public function readParameters() {
        parent::readParameters();

        if (isset($_REQUEST['id'])) {
            $this->rulebookArticleID = intval($_REQUEST['id']);
        }
        $this->rulebookArticle = new RulebookArticle($this->rulebookArticleID);
        if (!$this->rulebookArticle->rulebookArticleID) {
            throw new IllegalLinkException();
        }

        if (!WCF::getUser()->getUserID() == $this->rulebook->creatorID) {
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
                'articleOrder'              =>  $this->articleOrder,
                'rulebookArticleName'		=>  $this->rulebookArticleName,
            ),
        );

        // update page
        $action = new RulebookArticleAction(array($this->rulebookArticleID), 'update', $data);
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

        $this->articleOrder = $this->rulebookArticle->articleOrder;
        $this->rulebookArticleName = $this->rulebookArticle->rulebookArticleName;
    }

    /**
     * @see wcf\page\IPage::assignVariables()
     */
    public function assignVariables() {
        parent::assignVariables();
        WCF::getTPL()->assign(array(
            'action'                    =>  'edit',
            'articleOrder'              =>  $this->articleOrder,
            'rulebookArticle'           =>  $this->rulebookArticle,
            'rulebookArticleName'		=>  $this->rulebookArticleName,
        ));
    }
}