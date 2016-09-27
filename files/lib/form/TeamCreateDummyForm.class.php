<?php
/**
 * Created by Trollgon.
 * Date: 26.09.2016
 * Time: 14:13
 */

namespace teamsystem\form;


use teamsystem\data\team\TeamAction;
use teamsystem\util\TeamUtil;
use wcf\form\AbstractForm;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;
use wcf\util\HeaderUtil;

class TeamCreateDummyForm extends AbstractForm
{
    public $accept = false;

    /**
     * @see	\wcf\page\AbstractPage::$activeMenuItem
     */
    public $activeMenuItem = 'teamsystem.header.menu.teams';

    /**
     * @see    \wcf\page\AbstractPage::$loginRequired
     */
    public $loginRequired = true;

    /**
     * @see \wcf\page\AbstractPage::show()
     */
    public function show() {
        if(!WCF::getSession()->getPermission("mod.teamSystem.canCreateDummyTeams")) {
            throw new PermissionDeniedException();
        }
        parent::show();
    }

    /**
     * @see \wcf\form\AbstractForm::readFormParameters()
     */
    public function readFormParameters() {
        parent::readFormParameters();

        if (isset($_POST['accept'])) {
            $this->accept = true;
        }
    }

    /**
     * @see \wcf\form\AbstractForm::save()
     */
    public function save() {
        parent::save();
        $name = TeamUtil::getDummyTeamName();
        $data = array(
            'data' => array(
                'teamName'		    => $name,
                'teamTag'		    => TeamUtil::getDummyTeamTag(),
                'platformID'        => 0,
                'leaderID'          => 1,
                'contactID'         => 1,
                'dummyTeam'		    => 1,
                'teamDescription'   => "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labor"
            ),
        );
        $action = new TeamAction(array(), 'create', $data);
        $action->executeAction();
        HeaderUtil::delayedRedirect(LinkHandler::getInstance()->getLink('Team', array(
            'application' 	=> 'teamsystem',
            'id'			=> TeamUtil::getTeamIDByName($name),
        )),WCF::getLanguage()->get('teamsystem.team.create.successfulRedirect'), 10);
        exit;
    }
}