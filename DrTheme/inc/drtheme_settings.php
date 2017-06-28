<?php


/**
 * Include the required files
 */

// page settings sections & fields as well as the contextual help text.
require_once('drtheme_options.php');

/*
 * Specify Hooks/Filters
 */
add_action( 'admin_menu', 'DrTheme_add_menu' );
add_action( 'admin_init', 'DrTheme_register_settings' );

/**
 * Helper function: for defining variables for the current page
 *
 * @return array
 */
function DrTheme_get_settings() {
	$output = array();

	// put together the output array 
	$output['DrTheme_option_name'] 		= 'theme_Dr_options'; // the option name as used in the get_option() call.
	$output['DrTheme_page_title'] 		= __( 'DrTheme General Options','drtheme'); // the settings page title
	$output['DrTheme_page_sections'] 	= DrTheme_options_page_sections();// the settings tab
	$output['DrTheme_page_fields']		= DrTheme_options_page_fields(); // the setting section
	$output['DrTheme_contextual_help'] 	= DrTheme_options_page_contextual_help(); // the contextual help

	return $output;
}
/*
 * The Admin menu page
 */
function DrTheme_add_menu(){
	$settings_output        = DrTheme_get_settings();
	
    // collect our contextual help text
    $drtheme_contextual_help = $settings_output['DrTheme_contextual_help'];
	
	// Display Settings Page link under the "Appearance" Admin Menu
	$drtheme_settings_page = add_menu_page(__('DrTheme Setting','drtheme'), __('DrTheme Setting','drtheme'), 'manage_options',DRTHEME_PAGE_BASENAME,'DrTheme_settings_page_fn');		
	// contextual help
    if ($drtheme_settings_page) {
    	add_contextual_help( $drtheme_settings_page, $drtheme_contextual_help );
    }
	// css & js
	add_action( 'load-'. $drtheme_settings_page, 'DrTheme_settings_scripts' );
}

/*
 * Register our setting
 */
function DrTheme_register_settings(){
	
	// get the settings sections array
	$settings_output 	= DrTheme_get_settings();
	$drtheme_option_name = $settings_output['DrTheme_option_name'];
	//setting
	register_setting($drtheme_option_name, $drtheme_option_name, 'DrTheme_validate_options' );
	
	//sections
    if(!empty($settings_output['DrTheme_page_sections'])){
        // call the "add_settings_section" for each!
        foreach ( $settings_output['DrTheme_page_sections'] as $id => $title ) {
            add_settings_section( $id, $title, 'DrTheme_section_fn', __FILE__);
        }
    }
	//fields
    if(!empty($settings_output['DrTheme_page_fields'])){
        // call the "add_settings_field" for each!
        foreach ($settings_output['DrTheme_page_fields'] as $option) {
            DrTheme_create_settings_field($option);
        }
    }
	
}

/**
 * Helper function for registering our form field settings
 *
 * @param (array) $args The array of arguments to be used in creating the field
 * @return function call
 */
function DrTheme_create_settings_field( $args = array() ) {
	// default array to overwrite when calling the function
	$defaults = array(
		'id'      => 'default_field', 					// the ID of the setting in our options array, and the ID of the HTML form element
		'title'   => 'Default Field', 					// the label for the HTML form element
		'desc'    => 'This is a default description.', 	// the description displayed under the HTML form element
		'std'     => '', 								// the default value for this setting
		'type'    => 'text', 							// the HTML form element to use
		'section' => 'general_section',					// the section this setting belongs to � must match the array key of a section in DrTheme_options_page_sections()
		'choices' => array(), 							// (optional): the values in radio buttons or a drop-down menu
		'class'   => '', 								// the HTML form element class. Is used for validation purposes and may be also use for styling if needed.
		'placeholder'=>''
	);
	
	// "extract" to be able to use the array keys as variables in our function output below
	extract( wp_parse_args( $args, $defaults ) );
	
	// additional arguments for use in form field output in the function DrTheme_form_field_fn!
	$field_args = array(
		'type'      => $type,
		'id'        => $id,
		'desc'      => $desc,
		'std'       => $std,
		'choices'   => $choices,
		'label_for' => $id,
		'class'     => $class,
		'placeholder'=> $placeholder
	);

	add_settings_field( $id, $title, 'DrTheme_form_field_fn', __FILE__, $section, $field_args );
}

/**
 * Helper function for creating admin messages
 * src: http://www.wprecipes.com/how-to-show-an-urgent-message-in-the-wordpress-admin-area
 *
 * @param (string) $message The message to echo
 * @param (string) $msgclass The message class
 * @return echoes the message
 */
function DrTheme_show_msg($message, $msgclass = 'info') {
    echo "<div id='setting-error-settings_updated' class='$msgclass notice is-dismissible'>$message
    <button class='notice-dismiss' type='button'>
		<span class='screen-reader-text'>Close This Information?></span>
	</button></div>";
}

/*
 * Group scripts (js & css)
 */
function DrTheme_settings_scripts(){
    wp_enqueue_style('DrTheme_settings_css', DRTHEME_STYLES . 'drtheme_settings.css');
    wp_enqueue_script( 'DrTheme_settings_js', DRTHEME_SCRIPTS . 'drtheme_settings.js', array('jquery'),null, true);
}
// ************************************************************************************************************

// Callback functions

/*
 * Admin Settings Page HTML
 * 
 * @return echoes output
 */
function DrTheme_settings_page_fn() {
	if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'drtheme' ) );
    }
	// get the settings sections array
	$settings_output = DrTheme_get_settings();

?>
	<div class="wrap">
		<h2><?php echo $settings_output['DrTheme_page_title']; ?></h2>
		<form action="options.php" method="post" enctype="multipart/form-data">
			 <?php 
	            // http://codex.wordpress.org/Function_Reference/settings_fields
	            settings_fields($settings_output['DrTheme_option_name']);
				
	            // http://codex.wordpress.org/Function_Reference/do_settings_sections
	            do_settings_sections(__FILE__); 
            ?>
			<p class="submit">
				<input id="submit" name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Setting','drtheme'); ?>" />
				<input name="reset" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'drtheme'); ?>" />
			</p>
			
		</form>
	</div><!-- wrap -->
<?php } 

/*
 * Form Fields HTML
 * All form field types share the same function!!
 * 
 * @param (array) $args The array of arguments to be used in creating html output
 * @return echoes output
 */
function DrTheme_form_field_fn($args = array()) {
	
	extract( $args );
	
	// get the settings sections array
	$settings_output 	= DrTheme_get_settings();
	
	$drtheme_option_name = $settings_output['DrTheme_option_name'];
	$options 			= get_option($drtheme_option_name);
	
	// pass the standard value if the option is not yet set in the database
	if ( !isset( $options[$id] ) && 'type' != 'checkbox') {
		$options[$id] = $std;
	}
	
	// additional field class. output only if the class is defined in the create_setting arguments
	$field_class = ($class != '') ? ' ' . $class : '';
	
	// switch html display based on the setting type.	
	switch ( $type ) {
		case 'text':
			$options[$id] = stripslashes($options[$id]);
			$options[$id] = esc_attr( $options[$id]);
			echo "<input class='regular-text$field_class' type='text' id='$id' placeholder='$placeholder' name='" . $drtheme_option_name . "[$id]' value='$options[$id]' />";
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
		break;
		
		case 'checkbox':
			echo "<input class='checkbox$field_class' type='checkbox' id='$id' name='" . $drtheme_option_name . "[$id]' value='1' " . checked( $options[$id], 1, false ) . " />";
			echo ($desc != '') ? "<label for='$id'>$desc</label>" : "";
		break;
	}
}

/*
 * Validate input
 * 
 * @return array
 */
function DrTheme_validate_options($input) {
    // for enhanced security, create a new empty array
    $valid_input = array();
	// get the settings sections array
	$settings_output = DrTheme_get_settings();
	$options = $settings_output['DrTheme_page_fields'];
	if (isset($_POST['reset'])) {
		return $valid_input; 
	}
	// run a foreach and switch on option type
	foreach ($options as $option) {
		switch ( $option['type'] ) {
			case 'text':
				//switch validation based on the class!
				switch ( $option['class'] ) {
					//for numeric 
					case 'numeric':
						//accept the input only when numeric!
						$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
						$valid_input[$option['id']] = (is_numeric($input[$option['id']])) ? $input[$option['id']] : 'Expecting a Numeric value!';
					
						// register error
						if(is_numeric($input[$option['id']]) == FALSE) {
							add_settings_error(
								$option['id'], // setting title
								DRTHEME_SHORTNAME . '_txt_numeric_error', // error ID
								__('Expecting a Numeric value! Please fix.','drtheme'), // error message
								'error' // type of message
							);
						}
					break;
					//for multi-numeric values (separated by a comma)
					case 'multinumeric':
						//accept the input only when the numeric values are comma separated
						$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
						
						if($input[$option['id']] !=''){
							// /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.
							$valid_input[$option['id']] = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) == 1) ? $input[$option['id']] : __('Expecting comma separated numeric values','drtheme');
						}else{
							$valid_input[$option['id']] = $input[$option['id']];
						}
						
						// register error
						if($input[$option['id']] !='' && preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['id']]) != 1) {
							add_settings_error(
								$option['id'], // setting title
								DRTHEME_SHORTNAME . '_txt_multinumeric_error', // error ID
								__('Expecting comma separated numeric values! Please fix.','drtheme'), // error message
								'error' // type of message
							);
						}
					break;
					//for no html
					case 'nohtml':
						//accept the input only after stripping out all html, extra white space etc!
						$input[$option['id']] 		= sanitize_text_field($input[$option['id']]); // need to add slashes still before sending to the database
						$valid_input[$option['id']] = addslashes($input[$option['id']]);
					break;
					//for url
					case 'url':
						//accept the input only when the url has been sanited for database usage with esc_url_raw()
						$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
						$valid_input[$option['id']] = esc_url_raw($input[$option['id']]);
					break;
					//for email
					case 'email':
						//accept the input only after the email has been validated
						$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
						if($input[$option['id']] != ''){
							$valid_input[$option['id']] = (is_email($input[$option['id']])!== FALSE) ? $input[$option['id']] : __('Invalid email! Please re-enter!','drtheme');
						}elseif($input[$option['id']] == ''){
							$valid_input[$option['id']] = __('This setting field cannot be empty! Please enter a valid email address.','drtheme');
						}
						
						// register error
						if(is_email($input[$option['id']])== FALSE || $input[$option['id']] == '') {
							add_settings_error(
								$option['id'], // setting title
								DRTHEME_SHORTNAME . '_txt_email_error', // error ID
								__('Please enter a valid email address.','drtheme'), // error message
								'error' // type of message
							);
						}
					break;
					// a "cover-all" fall-back when the class argument is not set
					default:
						// accept only a few inline html elements
						$allowed_html = array(
							'a' => array('href' => array (),'title' => array ()),
							'b' => array(),
							'em' => array (), 
							'i' => array (),
							'strong' => array()
						);
						
						$input[$option['id']] 		= trim($input[$option['id']]); // trim whitespace
						$input[$option['id']] 		= force_balance_tags($input[$option['id']]); // find incorrectly nested or missing closing tags and fix markup
						$input[$option['id']] 		= wp_kses( $input[$option['id']], $allowed_html); // need to add slashes still before sending to the database
						$valid_input[$option['id']] = addslashes($input[$option['id']]); 
					break;
				}
			break;
			case 'checkbox':
				// if it's not set, default to null!
				if (!isset($input[$option['id']])) {
					$input[$option['id']] = null;
				}
				// Our checkbox value is either 0 or 1
				$valid_input[$option['id']] = ( $input[$option['id']] == 1 ? 1 : 0 );
			break;
		}
	}
return $valid_input; // return validated input
}

/**
 * Callback function for displaying admin messages
 *
 * @return calls DrTheme_show_msg()
 */
function DrTheme_admin_msgs() {
     
    // check for our settings page - need this in conditional further down
    $drtheme_settings_pg = strpos($_GET['page'], DRTHEME_PAGE_BASENAME);
    // collect setting errors/notices: //http://codex.wordpress.org/Function_Reference/get_settings_errors
    $set_errors = get_settings_errors(); 
     
    //display admin message only for the admin to see, only on our settings page and only when setting errors/notices are returned! 
    if(current_user_can ('manage_options') && $drtheme_settings_pg !== FALSE && !empty($set_errors)){
 
        // have our settings succesfully been updated? 
        if($set_errors[0]['code'] == 'settings_updated' && isset($_GET['settings-updated'])){
            DrTheme_show_msg("<p>" . $set_errors[0]['message'] . "</p>", 'updated');
         
        // have errors been found?
        }else{
            // there maybe more than one so run a foreach loop.
            foreach($set_errors as $set_error){
                // set the title attribute to match the error "setting title" - need this in js file
                DrTheme_show_msg("<p class='setting-error-message' title='" . $set_error['setting'] . "'>" . $set_error['message'] . "</p>", 'error');
            }
        }
    }
}
 
// admin messages hook!
add_action('admin_notices', 'DrTheme_admin_msgs');

function DrTheme_section_fn($desc) {
    echo __('Settings for this section','drtheme');
}

