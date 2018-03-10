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



/**
 * Function to sanitize function input parameters
*/
function sanitizeUserInputs(&$input, $filter)
{
	// $input...	input variable to filter
	// $filter...	filter to apply for input variable
	//	Numeric filter:		b|i¦d{default;min;max}
	//	List filter:		l{default;string1;string2;..;stringN}
	//	String filter:		s{TRIM|STRIP|ENTITY}

	// check if a valid filter was supplied
	if (!preg_match('#(b|i|d|s|l)#i', $filter, $match)) {
		echo 'Filter: <b>' . htmlentities($filter) . '</b> is no valid filter expression.';
		die;
	}

	// convert user input to array (allows to handle single values and array identical)
	$temp = is_array($input) ? $input : array($input);

	// evaluate filter expressions
	$filter_type = strtolower($match[1]);
	switch ($filter_type) {
		case 'b': case 'i': case 'd': // numeric filter ($input can be single value or array)
			// check if optional filter values are supplied (default, min, max)
			$advanced_filter = (preg_match('#(i|d)\{([-.0-9]+);([-.0-9]+);([-.0-9]+)\}#i', $filter, $match));

			// loop over input values
			foreach($temp as $key => $value) {
				// force type casting to either integer or double
				if ($filter_type == 'b') $temp[$key] = (boolean) $temp[$key];
				if ($filter_type == 'i') $temp[$key] = (int) $temp[$key];
				if ($filter_type == 'd') $temp[$key] = (double) $temp[$key];

				// check if value is within min/max range, if not use default value
				if ($advanced_filter) {
					$temp[$key] = ($temp[$key] >= $match[3] && $temp[$key] <= $match[4] ) ? $temp[$key] : $match[2];			
				}
			}
			break;
			
		case 'l': // list filter
			// check for correct list filter: l{default;list1;list2;..;listN}
			if (!preg_match('#(l)\{([^;]+?);(.+)\}#i', $filter, $match)) {
				echo 'List filter: <b>' . htmlentities($filter) . '</b> invalid. Usage: <b>l{default;list1;list2;..listN}</b>.';
				die;
			}

			// create array with list values from regular expression
			$list_values = explode(';', $match[3]);
			
			// loop over input values
			foreach($temp as $key => $value) {
				// check if value is in list (return default value if not in list)
				$temp[$key] = (in_array($value, $list_values) ? $value : $match[2]);
			}
			break;

		case 's': // string filter
			// check for correct string filter: s{TRIM|STRIP|ENTITY}
			if (!preg_match('#(s)\{(.+)\}#i', $filter, $match)) {
				echo 'String filter: <b>' . htmlentities($filter) . '</b> invalid. Usage: <b>s{STRIP;TRIM;ENTITIES}</b>.';
				die;
			}

			// get filter options from regular expression
			$filter_options = strtoupper($match[2]);

			// loop over input values
			foreach($temp as $key => $value) {
				// check if value is in list (return default value if not in list)
				if (strpos($filter_options, 'STRIP') !== false) $temp[$key] = strip_tags($temp[$key]);
				if (strpos($filter_options, 'TRIM') !== false) $temp[$key] = trim($temp[$key]);
				if (strpos($filter_options, 'ENTITIES') !== false) $temp[$key] = htmlentities($temp[$key]);
			}
			break;			
	}
	
	// revert user input back to array or single value
	$input = is_array($input) ? $temp : $temp[0];
}

/**
 * Function to fetch user defined output variables from short/long news database fields
*/
function getCustomOutputVariables($content, $regex_array, $var_prefix = '')
{
	if (!is_array($regex_array)) return array();

	$var_prefix = strtoupper($var_prefix);
	$custom_placeholders = array();
	// loop over all regular expressions defined by the user
	foreach($regex_array as $placeholder => $regex) {
		$placeholder = strtoupper($placeholder);
		
		// check for shorthand regex to fetch content from HTML tags (%TAG%)
		if (preg_match('#%(.*?)%#i', $regex, $match)) {
			$tag = strtolower(str_replace('%', '', $match[1]));
			$tag_regex = ($tag == 'img') ? '#(<img[^>]*[/]??>)#i' : '#<' . $tag . '[^>]*>(.*?)</' . $tag . '>#i';

			// check if shorthand regex matches
			if (preg_match_all($tag_regex, $content, $match)) {
				foreach($match[1] as $index => $value) {
					$custom_placeholders[$var_prefix . '_' . $placeholder . '_' . ($index + 1)] = $value;
				}
			}

		} elseif (preg_match('#(.*)#', $regex, $match)) {
			// check for user defined regex to fetch content from
			if (preg_match_all($match[0], $content, $match)) {
				// check if a capturing group was defined (allow only one)
				$match = (count($match) == 1) ? $match : $match[1];
				
				// return all matches found
				foreach($match as $index => $value) {
					$custom_placeholders[$var_prefix . '_' . $placeholder . '_' . ($index + 1)] = $value;
				}
			}
		}
	}
	return $custom_placeholders;
}

/**
 * Function to page_ids matching selected lang_id
*/
function getPageIdsByLanguage($lang_id)
{
	global $database;
	
	$table = TABLE_PREFIX . 'pages';
	$sql = "SELECT `page_id` FROM `$table` WHERE `language` = '$lang_id'";

	// fetch data from the database
	$results = $database->query($sql);
	
	$page_ids = array();
	while ($results && $row = $results->fetchRow()) {
		$page_ids[] = $row['page_id'];
	}
	return $page_ids;
}