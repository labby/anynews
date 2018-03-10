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
    /**
     *  The default template file name.
     *  @var    string  
     */
    const DEFAULT_TEMPLATE = "display_mode_1.lte";

    /**
     *  The current used templatename.
     *  @var    string
     */
    public $currentTemplate = self::DEFAULT_TEMPLATE;

    /**
     *  Private storage for requested user detailes.
     *  @var    array   $requestedUsers
     *
     */
    private $requestedUsers = array();
    
    /**
     *  Assc. array with all group-names.
     *  @var    array $allGroups
     */
    public $allGroups = array();
    
    // Own instance for this class!
    static $instance;
	
	//  Initialize the object
    public function initialize()
    {   
        self::$instance->allGroups = news::getInstance()->allGroups;
    }
    
    /**
     *  Returns the username and display-name from a given id.
     *  @param  integer $iUserID    A valiud user-id.
     *  @return array   Assoc. array with the username and displayname
     */
    public function getUserInfo( $iUserID = 0 )
    {        
        if(!isset($this->requestedUsers[ $iUserID ]))
        {
            // Not known - so we 'ask' the admin
            $this->requestedUsers[ $iUserID ] = LEPTON_admin::get_user_details( $iUserID );
        }
        
        return $this->requestedUsers[ $iUserID ];
    }
}
