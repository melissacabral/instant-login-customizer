<?php 
/*
Plugin Name: Instant Login Customizer
Description: Applies your Custom WP Background, Logo, and header to the Login and Register screens
Author: Melissa Cabral
Plugin URI: http://wordpress.melissacabral.com
Author URI: http://melissacabral.com
Version: 0.1
License: GPLv3
*/
function ilc_init(){
	if (!current_theme_supports('custom-background')) {
		add_theme_support( 'custom-background' );
	}
	if (!current_theme_supports('custom-logo')) {
		add_theme_support( 'custom-logo' );
	}
	if (!current_theme_supports('custom-header')) {
		add_theme_support( 'custom-header' );
	}
}
add_action( 'after_setup_theme', 'ilc_init' );
/**
 * Make sure a color has a hex # symbol at the beginning
 * @param  [type] $color [description]
 * @return [type]        [description]
 */
function ilc_add_hash($color){
	if(strlen($color) == 6 OR strlen($color) == 3){
		if(!strpos($color, '#')){
			return '#' . $color;
		}
	}else{
		return $color;
	}
}



function ilc_settings_api_init() {
 	// Add the section to reading settings so we can add our
 	// fields to it
 	add_settings_section(
		'ilc_setting_section',
		'Example settings section in reading',
		'ilc_setting_section_callback_function',
		'ilc-login-settings'
	);
 	
 	// Add the field with the names and function to use for our new
 	// settings, put it in our new section
 	add_settings_field(
		'ilc_setting_name',
		'Example setting Name',
		'ilc_setting_callback_function',
		'ilc-login-settings',
		'ilc_setting_section'
	);
 	
 	// Register our setting so that $_POST handling is done for us and
 	// our callback function just has to echo the <input>
 	register_setting( 'ilc_settings', 'ilc_setting_name' );
 } // ilc_settings_api_init()
 
 add_action( 'admin_init', 'ilc_settings_api_init' );
 
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
 
 function ilc_setting_section_callback_function() {
 	echo '<p>Intro text for our settings section</p>';
 }
 
 // ------------------------------------------------------------------
 // Callback function for our example setting
 // ------------------------------------------------------------------
 //
 // creates a checkbox true/false option. Other types are surely possible
 //
 
 function ilc_setting_callback_function() {
 	echo '<input name="ilc_setting_name" id="ilc_setting_name" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'ilc_setting_name' ), false ) . ' /> Explanation text';
 }




// /**
//  * Add a textarea for more custom CSS for the login
//  * @param   $wp_customize 
//  * @return                
//  * @todo Make this into a dedicated settings page, not the customizer screen (makes no sense since you can't see the login form!)
//  */
// function ilc_settings(){
// 	register_setting( 'ilc_settings', 'ilc_settings', 'ilc_sanitize' );
// 	update_option( 'ilc_settings');

// }
// add_action('admin_init', 'ilc_settings' );


// *
//  * Cleans inputs from admin panel form
//  * @param array $input raw data
//  * @return array        DB ready data
//  * @todo make this work!
 
// function ilc_sanitize($input){
	
// 	return $input;
// }
/**
 * Admin Panel Page
 */
function ilc_options_page(){
	add_theme_page( 'Login Form', 'Login Form', 'manage_options', 'ilc-login-settings', 'ilc_page_html' );
}
add_action( 'admin_menu', 'ilc_options_page' );

function ilc_page_html(){
	
	if(current_user_can('manage_options' )){

		include(plugin_dir_path(__FILE__ ) . '/form.php');
		
	}else{
		
	}
}

/**
 * Embedded CSS Output
 */

function ilc_custom_css(){
	$bg_color = ilc_add_hash(get_background_color());
	
	?>
	<!-- Instant Login Customizer by Melissa Cabral-->
	<style type="text/css">
		body, html{
			background-color:<?php echo $bg_color; ?>;
		}
		<?php if(has_custom_logo()): 
		$logo_image =  wp_get_attachment_image_url( get_theme_mod( 'custom_logo'));
		?>
		.login h1 a{
			background-image:url(<?php echo $logo_image ?>);
			width:auto;
			background-size:contain;
		}
	<?php endif; //custom logo ?>
</style>
<?php
}
add_action( 'login_head', 'ilc_custom_css' );

