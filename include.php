<?php
/**
 * Code snippet: anynews
 *
 * This code snippets grabs news entries from the WebsiteBaker news
 * module and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php
 * file of the template.
 *
 * This file implements the Anynews function displayNewsItems.
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS WebsiteBaker 2.8.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @version     2.2.0
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl-3.0.html
 */

// prevent this file from being accessed directly
if (defined('WB_PATH') == false) {
	exit("Cannot access this file directly");
}

// function to display news items on every page via (invoke function from template or code page)
if (! function_exists('displayNewsItems')) {
	function displayNewsItems(
		$group_id = 0,                  // IDs of news to show, matching defined $group_id_type (default:=0, all news, 0..N, or array(2,4,5,N) to limit news to IDs matching $group_id_type)
		$max_news_items = 10,           // maximal number of news shown (default:= 10, min:=1, max:= 999)
		$max_news_length = -1,          // maximal length of the short news text shown (default:=-1 => full news length)
		$display_mode = 1,              // 1:=details (default); 2:=list; 3:=coda-slider; 4:flexslider; 4-98 (custom template: display_mode_X.htt); 99:=cheat sheet
		$lang_id = 'AUTO',              // language file to load and lang_id used if $lang_filer = true (default:= auto, examples: AUTO, DE, EN)
		$strip_tags = true,             // true:=remove tags from short and long text (default:=true); false:=don´t strip tags
		$allowed_tags = '<p><a><img>',  // tags not striped off (default:='<p><a><img>')
		$custom_placeholder = false,    // false:= none (default), array('MY_VAR_1' => '%TAG%#', ... 'MY_VAR_N' => '#regex_N#' ...)
		$sort_by = 1,                   // 1:=position (default), 2:=posted_when, 3:=published_when, 4:=random order, 5:=number of comments
		$sort_order = 1,                // 1:=descending (default), 2:=ascending
		$not_older_than = 0,            // 0:=disabled (default), 0-999 (only show news `published_when` date <=x days; 12 hours:=0.5)
		$group_id_type = 'group_id',    // type used by group_id to extract news entries (supported: 'group_id', 'page_id', 'section_id', 'post_id')
		$lang_filter = false            // flag to enable language filter (default:= false, show only news from a news page, which language fits $lang_id)
  	)
	{
		global $wb, $database, $LANG;

		/**
		 *	Is first arg = array() ... if so - we're using this one!
		 *
		 */
		if (is_array($group_id) ) {
			// param 1 is pass as an array! We're using this as our config!
				$defaults = array(
					'group_id' => 0,
					'max_news_items' => 10,
					'max_news_length' => -1,
					'display_mode' => 1,
					'lang_id' => 'AUTO',
					'strip_tags' => true,
					'allowed_tags' => '<p><a><img>',
					'custom_placeholder' => false,
					'sort_by' => 1,
					'sort_order' => 1,
					'not_older_than' => 0,
					'group_id_type' => 'group_id',
					'lang_filter' => false
				);
				// overwrite the defaults within the values  of the $config
				foreach($group_id as $key=>$val) {
					$defaults[ $key ] = $val;
				}
				
				foreach($defaults as $key=>$val) ${$key} = $val;
		}
		
		/**
		 * Include required Anynews files
		 */
		require_once ('code/anynews_functions.php');
		require_once ('thirdparty/truncate.php');
		require_once (WB_PATH . '/include/phplib/template.inc');

		/**
		 * Sanitize user specified function parameters
		 */
		sanitizeUserInputs($group_id, 'i{0;0;999}');
		sanitizeUserInputs($max_news_items, 'i{10;1;999}');
		sanitizeUserInputs($max_news_length, 'i{-1;0;250}');
		sanitizeUserInputs($display_mode, 'i{1;1;99}');
		sanitizeUserInputs($strip_tags, 'b');
		sanitizeUserInputs($allowed_tags, 's{TRIM}');
		sanitizeUserInputs($sort_by, 'i{1;1;5}');
		sanitizeUserInputs($sort_order, 'i{1;1;2}');
		sanitizeUserInputs($not_older_than, 'd{0;0;999}');
		sanitizeUserInputs($group_id_type, 'l{group_id;group_id;page_id;section_id;post_id}');
		sanitizeUserInputs($lang_filter, 'b');

		/**
		 * Include Anynews language file depending on defined $lang_id 
		 */
		$lang_id = getValidLanguageId($lang_id);
		loadLanguageFile($lang_id);

		/**
		 * Create template object and configure it
		 */
		$tpl = new Template(dirname(__FILE__) . '/templates');

		// configure handling of unknown {variables} (remove:=default, keep, comment)
		$tpl->set_unknowns('remove');

		// configure debug mode (0:= default, 1:=variable assignments, 2:=calls to get variable, 4:=show internals)
		$tpl->debug = 0;

		// set template file depending on $display_mode
		if (file_exists(dirname(__FILE__) . '/templates/display_mode_' . $display_mode . '.htt')) {
			// set user defined template
			$tpl->set_file('page', 'display_mode_' . $display_mode . '.htt');
		} else {
			// set default template
			$tpl->set_file('page', 'display_mode_1.htt');
		}

		// define "read more block" used to show/hide readmore link depending on long news content
		$tpl->set_block('page', 'readmore_link_block', 'readmore_link_block_handle');

		// define optional "custom block" which can be used in template files if needed
		$tpl->set_block('page', 'custom_block', 'custom_block_handle');

		// define "news block" used for text outputs of individual news items (news text, links etc.)  
		$tpl->set_block('page', 'news_block', 'news_block_handle');

		// define "news wrapper block" shown if at least one news entry exists
		$tpl->set_block('page', 'news_available_block', 'news_available_block_handle');

		// define "no news wrapper block" shown in no news entry exists
		$tpl->set_block('page', 'no_news_available_block', 'no_news_available_block_handle');

		// replace placeholders with values from language file
		foreach ($LANG['ANYNEWS'][0] as $key => $value) {
			$tpl->set_var($key, $value);
		}

		/**
		 * Work out SQL query for group_id, limiting news to display depedning by defined $news_filter
		 *  option 1: $group_id:=0 => '1'
		 *  option 2: $group_id:=X => `group_id_type` = 'X'
		 *  option 3: $group_id:=array(2,3) => `group_id_type` IN (2,3)
		 */
		// show all news items if 0 is contained in group_id array
		if (is_array($group_id) && in_array(0, $group_id)) $group_id = 0;

		// check for multiple groups or single group values
		if (is_array($group_id)) {
			// SQL query for multiple groups
			$sql_group_id = "t1.`$group_id_type` IN (" . implode(',', $group_id) . ")";
		} else {
			// SQL query for single or empty groups
			$sql_group_id = ($group_id) ? "t1.`$group_id_type` = '$group_id'" : '1';
		}

		/**
		 * Work out SQL query for the not older than option
		 * This options allows to restrict the matches to news not older than X days
		 */
		// work out current server time (also used for published_when and published_until checks)
		$server_time = time();
		
		$sql_not_older_than = '1';
		if ($not_older_than > 0) {
			$sql_not_older_than = ' (t1.`published_when` >= \'' . ($server_time - ($not_older_than * 24 * 60 * 60)) . '\')';
		}

		/**
		 * Work out SQL query to hide news added via news pages NOT matching $lang_id
		 * Requires to organize news items via news pages with page language set to $lang_id 
		 * Returns all news entries if no news page was found matching given $lang_id  
		 **/
		$sql_lang_filter = '1';
		if ($lang_filter) {
			// get all page_ids which page language match defined $lang_id  
			$page_ids = getPageIdsByLanguage($lang_id);
			if (count($page_ids) > 0) {
				$sql_lang_filter = 't1.`page_id` in (' . implode(',', $page_ids) . ')'; 
			}
		}

		/**
		 * Work out SQL sort by and sort order query string
		 */
		// creates SQL query for sort by option
		$order_by_options = array('t1.`position`', 't1.`posted_when`', 't1.`published_when`', 'RAND()', '`comments`');
		$sql_order_by = $order_by_options[$sort_by - 1];
		
		// creates SQL query for sort order option
		$sql_sort_order = ($sort_order == 1) ? 'DESC' : 'ASC';

		/**
		 * Perform SQL database query for Anynews
		 */
		$news_table = TABLE_PREFIX . 'mod_news_posts';
		$comments_table = TABLE_PREFIX . 'mod_news_comments';

		$sql = "SELECT t1.*, COUNT(`comment_id`) as `comments`
			FROM `$news_table` as t1
			LEFT JOIN `$comments_table` as t2
			ON t1.`post_id` = t2.`post_id`
			WHERE t1.`active` = '1'
			AND $sql_group_id
			AND $sql_lang_filter
			AND (t1.`published_when` = '0' or t1.`published_when` <= '$server_time')
			AND (t1.`published_until` = '0' OR t1.`published_until` >= '$server_time')
			AND $sql_not_older_than
			GROUP BY t1.`post_id`
			ORDER BY $sql_order_by $sql_sort_order
			LIMIT 0, $max_news_items
		";
		
		/**
		 * Process database query and output the template files
		 */
		$results = $database->query($sql);
		if ($results && $results->numRows() > 0) {
			// fetch news group titles from news database table
			$news_group_titles = getNewsGroupTitles();

			// fetch user names from users database table
			$user_list = getUserNames();

			// loop through all news articles found
			$news_counter = 1;
			while ($row = $results->fetchRow()) {
				// build absolute links from [wblink] tags found in news short or long text database field
				$wb->preprocess($row['content_short']);
				$wb->preprocess($row['content_long']);

			 	// fetch custom placeholders from short/long text fields and replace template placeholders with values
				$custom_vars_short_text = getCustomOutputVariables($row['content_short'], $custom_placeholder, 'SHORT');
				$custom_vars_long_text = getCustomOutputVariables($row['content_long'], $custom_placeholder, 'LONG');
				$custom_vars = array_merge($custom_vars_short_text, $custom_vars_long_text);

				// replace custom placeholders in template with values
				foreach ($custom_vars as $key => $value) {
					$tpl->set_var($key, $value);
				}

				// remove tags from short and long text if defined
				$row['content_short'] = ($strip_tags) ? strip_tags($row['content_short'], $allowed_tags) : $row['content_short'];
				$row['content_long'] = ($strip_tags) ? strip_tags($row['content_long'], $allowed_tags) : $row['content_long'];

				// shorten news text to defined news length (-1 for full text length)
				if ($max_news_length != -1 && strlen($row['content_short']) > $max_news_length) {
					// consider start position if short content starts with <p> or <div>
					$start_pos = (preg_match('#^(<(p|div)>)#', $row['content_short'], $match)) ? strlen($match[0]) : 0;
					$row['content_short'] = truncate(substr($row['content_short'], $start_pos), $max_news_length, '...', false, true);
				}

				// work out group image if exists
				$group_id = $row['group_id'];
				$image = '';
				if (file_exists(WB_PATH . MEDIA_DIRECTORY . '/.news/image' . $group_id . '.jpg')) {
					$image = '<img src="' . WB_URL . MEDIA_DIRECTORY . '/.news/image' . $group_id . '.jpg' . '" alt="" />';
				}

				// replace news article dependend template placeholders
				$tpl->set_var(array(
					'WB_URL' => WB_URL, 
					'GROUP_IMAGE' => $image, 
					'NEWS_ID' => $news_counter, 
					'POST_ID' => (int)$row['post_id'], 
					'SECTION_ID' => (int)$row['section_id'], 
					'PAGE_ID' => (int)$row['page_id'], 
					'GROUP_ID' => (int)$row['group_id'], 
					'GROUP_TITLE' => array_key_exists($row['group_id'], $news_group_titles) ? htmlentities($news_group_titles[$row['group_id']]) : '',
					'POSTED_BY' => (int)$row['posted_by'], 
					'USERNAME' => array_key_exists($row['posted_by'], $user_list) ? htmlentities($user_list[$row['posted_by']]['USERNAME']) : '', 
					'DISPLAY_NAME' => array_key_exists($row['posted_by'], $user_list) ? htmlentities($user_list[$row['posted_by']]['DISPLAY_NAME']) : '', 
					'TITLE' => ($strip_tags) ? strip_tags($row['title']) : $row['title'], 
					'COMMENTS' => isset($row['comments']) ? $row['comments'] : 0, 
					'LINK' => WB_URL . PAGES_DIRECTORY . $row['link'] . PAGE_EXTENSION, 
					'CONTENT_SHORT' => $image . $row['content_short'], 
					'CONTENT_LONG' => $row['content_long'], 
					'POSTED_WHEN' => date($LANG['ANYNEWS'][0]['DATE_FORMAT'],$row['posted_when']), 
					'PUBLISHED_WHEN' => date($LANG['ANYNEWS'][0]['DATE_FORMAT'], $row['published_when']), 
					'PUBLISHED_UNTIL' => date($LANG['ANYNEWS'][0]['DATE_FORMAT'], $row['published_until'])
					)
				);

				// remove "read more block" from template if no long content is available
				$tpl->parse('readmore_link_block_handle', 'readmore_link_block', false);
				if (! isset($row['content_long']) || ! strlen($row['content_long']) > 0) {
					$tpl->set_var('readmore_link_block_handle', '');
				}

				// add optional custom template block in append mode (add per loop)
				$tpl->parse('custom_block_handle', 'custom_block', true);

				// add template values in news block in append mode (add per loop)
				$tpl->parse('news_block_handle', 'news_block', true);

				// remove custom variables to start blank for the next news entry
				foreach ($custom_vars as $key => $value) {
					$tpl->set_var($key, '');
				}

				$news_counter++;
			}
			// update the total number of news items
			$tpl->set_var('NEWS_ITEMS', $news_counter - 1);
			
			// remove the "no news available block" from output
			$tpl->set_var('no_news_available_block_handle', '');

			// parse the news content block
			$tpl->parse('news_available_block_handle', 'news_available_block', false);
			
		} else {
			// update the total number of news items
			$tpl->set_var('NEWS_ITEMS', 0);

			// remove the "news available block" from output
			$tpl->set_var('news_available_block_handle', '');

			// remove blocks not used
			$tpl->parse('no_news_available_block_handle', 'no_news_available_block', true);
		}
	
		// ouput the final template
		$tpl->pparse('output', 'page');
	}
}