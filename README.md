# Anynews Code Snippet for CMS LEPTON (1.x)
The code snippet `Anynews` is designed to fetch news entries from the [LEPTON CMS](http://www.lepton-cms.org) `news` module. Just call the Anynews function ***displayNewsItems();*** where you want the news output to appear on your frontend. Optional function parameters, HTML templates, content placeholders and CSS definitions allows you to style the news output the way you want. Anynews ships with four templates - including two jQuery sliding effects - ready for use out of the box.

Power users define their own placeholders containing information extracted from the short and/or long `news` module description. Mastering Anynews is possible - but requires you to study the information provided in the section ***Customizing Anynews***.

## Download
The released stable `Anynews` installation packages for the LEPTON CMS can be found on the [LEPTON homepage](http://www.lepton-cms.org/english/addons/free-addons.php). It is recommended to install/update to the latest available version listed. Older versions are provided for compatibility reasons with older LEPTON versions and may contain bugs or security issues. The development history of Anynews can be tracked via [GitHub](https://github.com/labby/anynews).

## License
Anynews is licensed under the [GNU General Public License (GPL) v3.0](http://www.gnu.org/licenses/gpl-3.0.html).

## Requirements
The minimum requirements to get Anynews running on your LEPTON installation are as follows:

- LEPTON ***1.x*** or higher
- default LEPTON `news` module
- PHP ***5.3.x*** or higher
- Optional: small modification of your template file to enable jQuery support

## Installation
1. download the [current release](http://www.lepton-cms.org/english/addons/free-addons.php) LEPTON installation package
2. log into your LEPTON backend and go to the `Add-ons/Modules` section
3. install the downloaded zip archive via the LEPTON installer

### Enable jQuery support (optional)
If you want to use JavaScript effects or jQuery plugins with Anynews, you need to add one code line to your frontend template. Open your LEPTON frontend template file ***index.php*** in the [Addon File Editor](http://www.lepton-cms.org/english/addons/free-addons.php) and search for the following lines. 

	if (function_exists('register_frontend_modfiles')) {
		register_frontend_modfiles('css');
		register_frontend_modfiles('js');
	}

Change the code lines above as follows:

	if (function_exists('register_frontend_modfiles')) {
		register_frontend_modfiles('css');
		register_frontend_modfiles('jquery');
		register_frontend_modfiles('js');
	}

If you can't find the code above in the index.php of your template, simply at the last code block to the end of your &lt;head&gt;&lt;/head&gt; section.	
	
## Usage
As Anynews is designed to fetch news items from the LEPTON `news` module, you need to add some news entries with the `news` module **before** you can use Anynews. If no news are available, Anynews just outputs the message "No news available yet". Follow the steps below to add some news entries with the LEPTON `news` module.

1. log into your LEPTON backend and go to the `Pages` section
2. create a new page or section of type `News` (set visibility to None)
3. add some news entries (2-3) from the `news` page in the LEPTON backend

### Use Anynews from a page or section
Create a new page or section of type `Code` in the LEPTON backend and enter the following code to it.

	if (function_exists('displayNewsItems')) {
		displayNewsItems();
	}

The Anynews output is only visible at the pages/sections of your frontend, which contain the code above.

### Use Anynews from your template
To display news items at a fixed position on every page of your frontend, open the ***index.php*** file of your default frontend template with the [Addon File Editor](https://github.com/cwsoft/wb-addon-file-editor#readme). Then add the code below to the position in your template where you want the news output to appear.

	<?php
		if (function_exists('displayNewsItems')) {
			displayNewsItems();
		}
	?>

Visit the frontend of your webiste and check the Anynews output.

## Customizing Anynews
The Anynews output can be customized to your needs by three methods:

1. parameters of the Anynews ***displayNewsItems()*** function
2. customized Anynews template files ***templates/display_mode_X.htt***
3. customized CSS definitions in file ***/css/anynews.css***
	
### Anynews Parametes
Calling Anynews in it´s easiest form ***displayNewsItems();*** uses the default parameters shown below.

	displayNewsItems(
		$group_id = 0,
		$max_news_items = 10,
		$max_news_length = -1,
		$display_mode = 1,
		$lang_id = 'AUTO',
		$strip_tags = true,
		$allowed_tags = '<p><a><img>',
		$custom_placeholder = false,
		$sort_by = 1,
		$sort_order = 1,
		$not_older_than = 0,
		$group_id_type = 'group_id',
		$lang_filter = false
	);

***Function parameters explained:***

- **$group_id**: only show news which IDs match given *$group_id_type* (default 'group_id')  
	[0:all news, 1..N, or array(2,4,5,N) to limit news to single Id or multiple Ids, matching *$group_id_type*]
	
- **$max_news_items**: max. number of news entries to show  
	[valid: 1..999]
	
- **$max_news_length**: max. news length to be shown  
	[-1:= full length]
	
- **$display_mode**: ID of the Anynews template to use (/templates/display_mode_X.htt)  
	[1:details, 2:list, 3:better-coda-slider, 4:flexslider, 5..98 custom template *display_mode_X.htt*]  
	Hint: 99:cheat sheet with ALL Anynews placeholders available in the template files
	
- **$lang_id**: mode to detect language file to use  
	[allowed: 'AUTO', or a valid WB language file ID: 'DE', 'EN', ...]
	
- **$strip_tags**: flag to strip tags from news short/long text ***not*** contained in *$allowed_tags*  
	[true:strip tags, false:don't strip tags]
	
- **$allowed_tags**: tags to keep if *$strip_tags = true*
	[default: '&lt;p&gt;&lt;a&gt;&lt;img&gt;']

- **$custom_placeholder**: create own placeholders for usage in template files  
	**Example:** $custom\_placeholder = array('MY\_IMG' => '%img%', 'MY\_TAG' => '%author%', 'MY\_REGEX' => '#(test)#i')  
	
	Stores all image URLs, all text inside &lt;author&gt;&lt;/author&gt; tags and all matches of "test" in placeholders:  {PREFIX\_MY\_IMG\_#}, {PREFIX\_MY\_TAG\_#}, {PREFIX\_MY\_REGEX\_#}, where ***PREFIX*** is either "SHORT" or "LONG", depending if the match was found in the short/long news text and ***#*** is a number between 1 and the number of matches found
	
- **$sort_by**: defines the sort criteria for the news items returned  
	[1:position, 2:posted_when, 3:published_when, 4:random order, 5:number of comments]
	
- **$sort_order**: defines the sort order of the returned news items  
	[1:descending, 2:=ascending]
	
- **$not_older_than**: skips all news items which are older than X days  
	[0:don't skip news items, 0...999: skip news items older than x days (hint: 0.5 --> 12 hours)]

- **$group_id_type**: sets type used by group_id to extract news entries from  
	[supported: 'group_id', 'page_id', 'section_id', 'post_id')]

- **$lang_filter**: flag to enable language filter   
	[default:= false, true:=only show news added from news pages, which page language match $lang_id]
	
***Tip:*** 
You can output a list with all *group_ids* and the *group titles* created by the LEPTON `news` module, by adding the following code into a page/section of type `code`.

	require_once(WB_PATH . '/modules/anynews/code/anynews_functions.php');
	print_r(getNewsGroupTitles());

Visit the created page/section in your frontend and search for the *group_id(s)* you want to use in the Anynews function call. 
	
### Anynews Templates
The HTML skeleton of the Anynews output is defined by template files **templates/display_mode_X.htt**. The template to be used is defined by the Anynews function parameter **$display_mode**, which defaults to 1 if no valid input is defined. Create a blank template file with the [Addon File Editor](https://github.com/cwsoft/wb-addon-file-editor#readme) and name as follows: **templates/display_mode_5.htt**

#### Step 1:
Add the HTML markup below to your custom template file. The entire HTML output should be wrapped in a div with class "mod_anynews" to prevent CSS clashes with other modules, templates or the LEPTON core. 

The example includes two logical blocks defined by simple HTML comments following `<!-- BEGIN block_name --> and <!-- END block_name -->`. The first block provides the HTML output for ONE single news entry. The second block provides a status message if no news items exists. Please note that only one of the two blocks is visible in your frontend. If no news exists, the first block will be removed, if at least one news item exists, the second block is removed.

	<div class="mod_anynews">
		<!-- BEGIN news_available_block -->		
			<h1>Dummy page header shown only once</h1>
		
			<h2>Dummy news header</h2>
			<p>Dummy news text </p>
			<em>Dummy news author</em>
		<!-- END news_available_block -->		

		<!-- BEGIN no_news_available_block -->
			<p>No news available yet</p>
		<!-- END no_news_available_block -->
	</div>

#### Step 2:
Identify the template part containing the content for the single news item. Wrap the two single HTML comment lines around this block. This tells Anynews to repeat the encapsulated HTML block for EACH news item returned by Anynews. Your Anynews template should now look as follows.

	<div class="mod_anynews">
		<!-- BEGIN news_available_block -->		
			<h1>Dummy page header shown only once</h1>
		
			<!-- BEGIN news_block -->
				<h2>Dummy news header</h2>
				<p>Dummy news text </p>
				<em>Dummy news author</em>
			<!-- END news_block -->
		<!-- END news_available_block -->		

		<!-- BEGIN no_news_available_block -->
			<p>No news available yet</p>
		<!-- END no_news_available_block -->
	</div>
	
#### Step 3:	
Finally replace the dummy text with the Anynews content {placeholders}. The {placeholders} are replaced with data from the LEPTON `news` entries. Review the template file ***display_mode_99.htt*** (cheat sheet) to get a list of all available Anynews placeholders. Our final result will look like this.

	<div class="mod_anynews">
		<!-- BEGIN news_available_block -->		
			<h1>Dummy page header shown only once</h1>
		
			<!-- BEGIN news_block -->
				<h2>{TITLE}</h2>
				<p>{CONTENT_LONG}</p>
				<em>{POSTED_BY}</em>
			<!-- END news_block -->
		<!-- END news_available_block -->		

		<!-- BEGIN no_news_available_block -->
			<p>{TXT_NO_NEWS}</p>
		<!-- END no_news_available_block -->
	</div>

If you want to create a custom template with jQuery effects, look at the template files ***display_mode_3.htt*** and ***display_mode_4.htt***, which implement 3rd party jQuery sliding effects.

### Anynews CSS
The Anynews default templates (*/templates/display_mode_X.htt*) wrap the Anynews output in a div container as shown below.

	<div class="mod_anynews">
		<h2>Dummy Header</h2>
		<p>Dummy news text to explain</p>
	</div>
	
To change the news header of aboves example to green and the news text to blue, open the ***css/anynews.css*** file in the [Addon File Editor](http://www.lepton-cms.org/english/addons/free-addons.php) and add the following CSS definitions.

	div.mod_anynews h2 {
		color: green;
	}

	div.mod_anynews p {
		color: blue;
	}

***Note:*** This is common practice to limit the scope of the CSS defintions to the Anynews container. This practice ensures that your CSS definitions do not overwrite styles defined in other modules, templates or the LEPTON core. You should stick to this good practice when creating your own template files.
	
## Known Issues
You can track the status of known issues or report new issues found in Anynews via GitHubs [issue tracking service](https://github.com/labby/anynews/issues). If you run into any issues with Anynews, please visit this page first and check if this issue is already known.

## Questions
If you have questions or issues with Anynews, please visit the [English](http://forum.lepton-cms.org/) LEPTON forum support threads and ask for feedback.

***Always provide the following information with your support request:***

 - detailed error description (what happens, what have you already tried ...)
 - the Anynews version (go to LEPTON section Add-ons / Info / Anynews)
 - your PHP version (use phpinfo(); or ask your provider if in doubt)
 - LEPTON version, Service Pack number and build number of your version
 - name of the LEPTON frontent template used (e.g. round, allcss ...)
 - information about your operating system (e.g. Windows, Mac, Linux) incl. version
 - information of your browser and browser version used
 - information about changes you made to LEPTON (if any)
