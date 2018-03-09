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

    private $requestedUsers = array();
    
    public $allGroups = array();
    
    // Own instance for this class!
    static $instance;
	
    public function initialize()
    {   
        self::$instance->allGroups = news::getInstance()->allGroups;
    }
    
    public function getUserInfo( $iUserID = 0 )
    {        
        if(!isset($this->requestedUsers[ $iUserID ]))
        {
            $this->requestedUsers[ $iUserID ] = LEPTON_admin::get_user_details( $iUserID );
       
        }
        return $this->requestedUsers[ $iUserID ];
    }
}
