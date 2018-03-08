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

// include class.secure.php to protect this file and the whole CMS!
if (defined('LEPTON_PATH')) {	
	include(LEPTON_PATH.'/framework/class.secure.php'); 
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

// LEPTON 4*
$to_delete = array(
	'/modules/anynews/frontend.js',
	'/modules/anynews/css/anynews.css',
	'/modules/anynews/css/custom-settings-better-coda-slider.css',
	'/modules/anynews/css/custom-settings-flexslider.css'
);

LEPTON_handle::delete_obsolete_files($to_delete)

if(file_exists(LEPTON_PATH.'/modules/anynews/frontend.css')) {	
	rename(LEPTON_PATH.'/modules/anynews/frontend.css',LEPTON_PATH.'/modules/anynews/css/frontend_sik.css');
}


?>
