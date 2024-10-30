<?php
/*
Plugin Name: BrainPOP UK featured movie
Plugin URI: http://www.brainpop.co.uk/blog/request-a-popbox/popbox-wordpress-plugin/
Description: Displays the current featured BrainPOP UK movie
Author: John McLear
Version: 0.4
Author URI: http://mclear.co.uk
License: GNU GPL2
*/

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.
function widget_brainwidget_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	// This function prints the sidebar widget--the cool stuff!
	function widget_brainwidget($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_brainwidget');
		$title = empty($options['title']) ? 'BrainPOP UK' : $options['title'];
		$text = empty($options['text']) ? '200' : $options['text'];
		$text = $options['text'];

		if ($text == 200){$brainpop_id="1212";}
		if ($text == 225){$brainpop_id="1217";}
		if ($text == 250){$brainpop_id="1214";}
		if ($text == 275){$brainpop_id="1215";}
		if ($text == 350){$brainpop_id="1216";}

		if (isset($text)){}else{$brainpop_id="1212";$text=200;}

		$params = "$brainpop_id,$text,$text,1,\"uk\"";

		$javascript = "
		<!--BEGIN BRAINPOP PARTNER CODE -->
		<script language=\"JavaScript\" src=\"http://www.brainpop.co.uk/partners/brainpop_partners.js\" type=\"text/javascript\"></script>
		<script type=\"text/javascript\">get_partner_container($params);
		</script><!--END BRAINPOP PARTNER CODE-->";



 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo $javascript;
		echo $after_widget;
	}

	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_brainwidget_control() {

		// Collect our widget's options.
		$options = get_option('widget_brainwidget');

		// This is for handing the control form submission.
		if ( $_POST['brainwidget-submit'] ) {
			// Clean up control form submission options
			$newoptions['title'] = strip_tags(stripslashes($_POST['brainwidget-title']));
			$newoptions['text'] = strip_tags(stripslashes($_POST['brainwidget-text']));
		}

		// If original widget options do not match control form
		// submission options, update them.
//print_r($newoptions);
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_brainwidget', $options);
		}

		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
//		$text = htmlspecialchars($options['text'], ENT_QUOTES);

// The HTML below is the control form for editing options.
?>
		<div>
		<label for="brainwidget-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="brainwidget-title" name="brainwidget-title" value="<?php echo $title; ?>" />
		</label>
		<label for="brainwidget-text" style="line-height:35px;display:block;">
		Video Size: 
		<select id="brainwidget-text" name="brainwidget-text" value="<?php echo $options['text']; ?>">
		<?php $newtext = $options['text'];
		if(isset($newtext)){
		echo "<option value=$newtext>$newtext</option>";
		}?>
		<option value=200>200</option>
		<option value=225>225</option>
		<option value=250>250</option>
		<option value=275>275</option>
		<option value=350>350</option>
		</select>
		</label>
		<input type="hidden" name="brainwidget-submit" id="brainwidget-submit" value="1" />
		</div>
	<?php
	// end of widget_brainwidget_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('Brain POP UK', 'widget_brainwidget');

	// This registers the (optional!) widget control form.
	register_widget_control('Brain POP UK', 'widget_brainwidget_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_brainwidget_init');
?>
