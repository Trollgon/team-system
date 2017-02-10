<?php
/**
 * Created by Trollgon.
 * Date: 10.02.2017
 * Time: 14:29
 */

namespace tourneysystem\data\tourney;

use wcf\data\DatabaseObjectEditor;

class TourneyEditor extends DatabaseObjectEditor  {
    /**
     * @see	\wcf\data\DatabaseObjectDecorator::$baseClass
     */
    protected static $baseClass = 'tourneysystem\data\tourney\Tourney';
}