<?php

/**
 * Code snippet: anynews
 *
 * This code snippets grabs news entries from the WebsiteBaker news
 * module and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php
 * file of the template.
 *
 * This file checks the installation requirements atinstallation
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS LEPTON 1.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @version     see info.php of this addon
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {	
	include(WB_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

$PRECHECK = array();

// Checking Requirements

$PRECHECK['VERSION']        = array(
    'VERSION' => '1.0',
    'OPERATOR' => '>='
);

$PRECHECK['WB_ADDONS']      = array(
    'news' => array(
        'VERSION' => '3.6.0',
        'OPERATOR' => '>='
    ),
);

?>
