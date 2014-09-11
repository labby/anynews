<?php
/**
 * Code snippet: anynews
 *
 * This code snippets grabs news from the WB news module database
 * and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php 
 * file of the template.
 *
 * This file contains the German language output.
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS Websitebaker 2.8.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @translation	cwsoft
 * @version     2.2.0
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
*/

// German module description
$module_description	= 'Die Zusatzfunktion Anynews erlaubt das anzeigen von Beitr&auml;gen des News-Moduls auf beliebigen Seiten. Die Funktion kann im Template oder von einer Seite/Abschnitt des Typs Code aufgerufen werden. Weitere Informationen auf <a href="https://github.com/cwsoft/wb-anynews" target="_blank">GitHub</a>.';

// initialize global $LANG variable as array if needed
if (! isset($LANG) || (isset($LANG) && ! is_array($LANG))) {
	$LANG = array();
}

$LANG['ANYNEWS'][0] = array(
	// text outputs for the frontend
	'TXT_HEADER' => 'Aktuelle Nachrichten', 
	'TXT_READMORE' => 'weiter lesen', 
	'TXT_NO_NEWS' => 'Keine Nachrichten vorhanden.',
	'TXT_NEWS' => 'Nachricht', 
	'TXT_NUMBER_OF_COMMENTS' => 'Anzahl Kommentare', 
	
	// date/time format: (21:12, 31.12.2012)
	'DATE_FORMAT' => ' (H:i, d.m.Y)'
);