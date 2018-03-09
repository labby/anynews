<?php

/**
 * @module          anynews
 * @author          cwsoft, LEPTON project
 * @copyright       cwsoft, LEPTON project
 * @link            http://www.cms-lab.com
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @license_terms   please see license
 *
 */

class anynews extends LEPTON_abstract
{
    const DEFAULT_TEMPLATE = "display_mode_1.lte";

    public $currentTemplate = self::DEFAULT_TEMPLATE;

    private $allUsers = array();
    
    public $allGroups = array();
    
    // Own instance for this class!
    static $instance;
	
    public function initialize()
    {
        self::$instance->getAllUsers();
        
        self::$instance->allGroups = news::getInstance()->allGroups;
    }

    private function getAllUsers()
    {
        $aTemp = array();
        LEPTON_database::getInstance()->execute_query(
            "SELECT `user_id`,`username`,`display_name` FROM `".TABLE_PREFIX."users`",
            true,
            $aTemp,
            true
        );
        
        foreach($aTemp as $user)
        {
            self::$instance->allUsers[ $user['user_id'] ] = array(
                'username' => $user['username'],
                'display_name'  => $user['display_name']
            );
        }
    }
}
