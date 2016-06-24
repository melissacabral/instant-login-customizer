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

add_action( 'after_setup_theme', 'ilc_init' );
function ilc_init(){
	// Make sure necessary theme support is on
	if (!current_theme_supports('custom-background')) {
		add_theme_support( 'custom-background' );
	}
	if (!current_theme_supports('custom-logo')) {
		add_theme_support( 'custom-logo' );
	}
	// if (!current_theme_supports('custom-header')) {
	// 	add_theme_support( 'custom-header' );
	// }
}


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



/**
 * Create the settings group for the plugin
 * @param   
 * @return                
 * 
 */
function ilc_settings(){
	register_setting( 'ilc_settings', 'ilc_settings', 'ilc_sanitize' );
	//create defaults
	add_option( 'ilc_settings', array(
		'use_logo' => 1,
		'use_background' => 1,
		'use_header' => 1,
		'custom_css' => '',
		));

}
add_action('admin_init', 'ilc_settings' );


/**
 * Cleans inputs from admin panel form
 * @param array $input raw data
 * @return array        DB ready data
 * @todo make this work!
 */
function ilc_sanitize($input){
	$input['use_logo'] = wp_filter_nohtml_kses( $input['use_logo'] );
	$input['use_logo'] = wp_filter_nohtml_kses( $input['use_logo'] );
	$input['use_background'] = wp_filter_nohtml_kses( $input['use_background'] );

	$input['custom_css'] = wp_filter_nohtml_kses( $input['custom_css'] );

	return $input;
}
/**
 * Admin Panel Page
 */
add_action( 'admin_menu', 'ilc_options_page' );
function ilc_options_page(){
	add_theme_page( 'Login Form', 'Login Form', 'manage_options', 'ilc-login-settings', 'ilc_page_html' );
}


function ilc_page_html(){	
	if(current_user_can('manage_options' )){
		include(plugin_dir_path(__FILE__ ) . '/form.php');		
	}else{
		die('You do not have permission to view this page');
	}
}

/**
 * Embedded CSS Output
 */
add_action( 'login_head', 'ilc_custom_css' );
function ilc_custom_css(){
	$values = get_option('ilc_settings' );
	$bg_color = ilc_add_hash(get_background_color());
	
	?>
	<!-- Instant Login Customizer by Melissa Cabral-->
	<style type="text/css">
		body, html{
			background-color:<?php echo $bg_color; ?>;
		}
		<?php 
		//CUSTOM LOGO
		if(has_custom_logo() AND $values['use_logo'] ): 
		$logo_image =  wp_get_attachment_image_url( get_theme_mod( 'custom_logo'));
		?>
		.login h1 a{
			background-image:url(<?php echo $logo_image ?>);
			width:auto;
			background-size:contain;
		}
		<?php endif; //custom logo 

		//CUSTOM HEADER
		if(has_header_image() AND $values['use_header'] ): 
		$header_image =  get_header_image();
		?>
		.login h1 {
			background-image:url(<?php echo $header_image ?>);
			width:auto;
			background-size:contain;
		}
		<?php endif; //custom logo 

	echo $values['custom_css'];
	?>


</style>
<?php
}

