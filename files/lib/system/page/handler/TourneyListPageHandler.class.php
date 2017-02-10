<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 12:39
 */

namespace tourneysystem\system\page\handler;

use tourneysystem\data\invitation\InvitationList;
use wcf\system\page\handler\AbstractMenuPageHandler;
use wcf\system\WCF;

class TourneyListPageHandler extends AbstractMenuPageHandler {

    public function getOutstandingItemCount($objectID = null) {
        $invitationsList = new InvitationList();
        $invitationsList->getConditionBuilder()->add("invitation.playerID = ?", array(WCF::getUser()->getUserID()));
        return $invitationsList->countObjects();
    }
}