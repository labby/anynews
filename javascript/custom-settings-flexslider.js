/**
 * Code snippet: anynews
 *
 * This code snippets grabs news from the WB news module database
 * and displays them on any page you want by invoking the function
 * displayNewsItems() via a page of type code or the index.php 
 * file of the template.
 *
 * User defined JavaScript settings for the thirdparty jQuery plugin flexslider.
 * Detailed information about the jQuery flexslider plugin and it's settings can
 * be found on website of the authors: http://flex.madebymufffin.com/
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @platform    CMS Websitebaker 2.8.x
 * @package     anynews
 * @author      cwsoft (http://cwsoft.de)
 * @version     2.1.0
 * @copyright   cwsoft
 * @license     http://www.gnu.org/licenses/gpl.html
*/

$(document).ready(function() {
   // put all your jQuery goodness in here.
	$('.flexslider').flexslider({
		animation: 'slide',  			//String: Select your animation type, "fade" or "slide"
		slideDirection: 'horizontal',   //String: Select the sliding direction, "horizontal" or "vertical"
		slideshow: true,               	//Boolean: Animate slider automatically
		slideshowSpeed: 7000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
		animationDuration: 600,         //Integer: Set the speed of animations, in milliseconds
		directionNav: true,            	//Boolean: Create navigation for previous/next navigation? (true/false)
		controlNav: false,              //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
		keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
		mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
		prevText: 'Previous',           //String: Set the text for the "previous" directionNav item
		nextText: 'Next',               //String: Set the text for the "next" directionNav item
		pausePlay: false,               //Boolean: Create pause/play dynamic element
		pauseText: 'Pause',             //String: Set the text for the "pause" pausePlay item
		playText: 'Play',               //String: Set the text for the "play" pausePlay item
		randomize: false,               //Boolean: Randomize slide order
		slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
		animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
		pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
		pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
		
		controlsContainer: '.flex-container',
		manualControls: '',             
		start: function(){},            //Callback: function(slider) - Fires when the slider loads the first slide
		before: function(){},           //Callback: function(slider) - Fires asynchronously with each slider animation
		after: function(){},            //Callback: function(slider) - Fires after each slider animation completes
		end: function(){}               //Callback: function(slider) - Fires when the slider reaches the last slide (asynchronous)
	});
});