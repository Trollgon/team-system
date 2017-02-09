<?php
/**
 * Created by Trollgon.
 * Date: 16.01.2017
 * Time: 13:20
 */

namespace tourneysystem\system\page\handler;
use tourneysystem\data\invitation\InvitationList;
use wcf\system\page\handler\AbstractMenuPageHandler;
use wcf\system\WCF;

class InvitationListPageHandler extends AbstractMenuPageHandler {

    public function isVisible($objectID = null) {
        if (WCF::getUser()->getUserID() == 0) {
            return false;
        }
        else {
            return true;
        }
    }

    public function getOutstandingItemCount($objectID = null) {
        $invitationsList = new InvitationList();
        $invitationsList->getConditionBuilder()->add("invitation.playerID = ?", array(WCF::getUser()->getUserID()));
        return $invitationsList->countObjects();
    }
}