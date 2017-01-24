<?php
/**
 * Created by Trollgon.
 * Date: 16.01.2017
 * Time: 13:22
 */

namespace teamsystem\system\page\handler;


use teamsystem\data\invitations\InvitationList;
use wcf\system\page\handler\AbstractMenuPageHandler;
use wcf\system\WCF;

class TeamListPageHandler extends AbstractMenuPageHandler {

    public function getOutstandingItemCount($objectID = null) {
        $invitationsList = new InvitationList();
        $invitationsList->getConditionBuilder()->add("invitations.playerID = ?", array(WCF::getUser()->getUserID()));
        return $invitationsList->countObjects();
    }
}