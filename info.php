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

// OBLIGATORY VARIABLES
$module_directory = 'anynews';
$module_name = 'Anynews';
$module_function = 'snippet';
$module_version = '3.0.0';
$module_status = 'stable';
$module_platform = '4.x';
$module_author = 'cwsoft (http://cwsoft.de), LEPTON project (last)';
$module_license = '<a href="http://www.gnu.org/licenses/gpl.html">GNU General Public Licencse 3.0</a>';
$module_license_terms = '-';
$module_description = 'Call displayNewsItems(); from the index.php of your template or a code section to display news entries where you want them to be.';
$module_guid = '6886a21d-c3b9-4fec-a46e-e7f6e91a3ec9';
?>
