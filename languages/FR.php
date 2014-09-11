<?php
/**
 * Code snippet: anynews
 *
 * This code snippets grabs news from the WB news module database
 * and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php 
 * file of the template.
 *
 * This file contains the French language output.
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS Websitebaker 2.8.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @translation Guillaume Vielliard
 * @version     2.1.0
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */

// French module description
$module_description	= 'Code pour afficher des news sur différentes pages . Cette fonction peut être apellée depuis le template ou dans une section de code. Plus de détails sur ce module dans le fichier suivant <a href="https://github.com/cwsoft/wb-anynews" target="_blank">GitHub</a>.';

// initialize global $LANG variable as array if needed
if (! isset($LANG) || (isset($LANG) && ! is_array($LANG))) {
	$LANG = array();
}

$LANG['ANYNEWS'][0] = array(
	// text outputs for the frontend
	'TXT_HEADER' => 'Dernière news', 
	'TXT_READMORE' => 'Lire la suite', 
	'TXT_NO_NEWS' => 'Pas encore de news.',
	'TXT_NEWS' => 'News', 
	'TXT_NUMBER_OF_COMMENTS' => 'Number of comments', 
	
	// date/time format: (9:12 PM, 31/12/2012)
	'DATE_FORMAT' => ' (H:i A, d/m/Y)'
);