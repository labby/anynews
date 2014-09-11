<?php
/**
 * Code snippet: anynews
 *
 * This code snippets grabs news from the WB news module database
 * and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php 
 * file of the template.
 *
 * This file contains the Serbian language output.
 *
 * LICENSE: GNU General Public License 3.0
 *
 * @platform    CMS Websitebaker 2.8.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @translation	forum member Mirens
 * @version     2.2.0
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

// Serbian module description
$module_description	= 'Website Baker modul za prikazivanje novosti na bilo kojoj stranici vašeg web site-a. Funkcija modula može biti implementirana u sam template ili putem code sekcije. Detalji i pomo&#263; oko koriš&#263;enja ovog modula mogu se na&#263;i u samom modulu na linku <a href="https://github.com/cwsoft/wb-anynews" target="_blank">GitHub</a>.';

// initialize global $LANG variable as array if needed
if (! isset($LANG) || (isset($LANG) && ! is_array($LANG))) {
	$LANG = array();
}

$LANG['ANYNEWS'][0] = array(
	// text outputs for the frontend
	'TXT_HEADER' => 'Najnovije vesti',
	'TXT_READMORE' => 'detaljnije',
	'TXT_NO_NEWS' => 'Vesti ne postoje u bazi.',
	'TXT_NEWS' => 'Novosti',
	'TXT_NUMBER_OF_COMMENTS' => 'Number of comments', 
	
	// date/time format: (9:12 PM, 10/20/2008)
	'DATE_FORMAT' => ' | d.m.Y. - H:i'
);