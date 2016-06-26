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
	if (!current_theme_supports('custom-header')) {
		add_theme_support( 'custom-header' );
	}
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
 * Calculate contrasting color for the links below the login form
 * against the custom bg color
 * @param $hexcolor  a 6 digit color, like FFCC00
 */
function ilc_get_contrast($hexcolor){
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));
	$yiq = (($r*299)+($g*587)+($b*114))/1000;
	return ($yiq >= 128) ? 'black' : 'white';
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
	$input['css_theme'] = wp_filter_nohtml_kses( $input['css_theme'] );


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
 * Enqueue an optional CSS theme
 */
add_action('login_enqueue_scripts', 'ilc_nq_css' );
function ilc_nq_css(){
	$values = get_option( 'ilc_settings' );
	$css = $values['css_theme'];
	if($css){
		$url = plugins_url( 'themes/' . $css . '.css', __FILE__ );
		wp_enqueue_style( 'ilc_theme_css', $url );
	}
}

/**
 * Embedded CSS Output
 */
add_action( 'login_head', 'ilc_custom_css' );
function ilc_custom_css(){
	$values = get_option('ilc_settings' );
	?>
	<!-- Instant Login Customizer by Melissa Cabral-->
	<style type="text/css">
		<?php 
		if($values['use_background'] && get_background_color()):
			$bg_color = get_background_color();
			$contrast = ilc_get_contrast($bg_color);
			$bg_color = ilc_add_hash($bg_color);
			$background = get_background_image();
		?>
		body, html{
			background-color:<?php echo $bg_color; ?>;
			<?php
			if ( $background ) {
				$image = " background-image: url('$background');";

				$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
				if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
					$repeat = 'repeat';
				$repeat = " background-repeat: $repeat;";

				$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
				if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
					$position = 'left';
				$position = " background-position: top $position;";

				$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
				if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
					$attachment = 'scroll';
				$attachment = " background-attachment: $attachment;";

				echo  $image . $repeat . $position . $attachment;
			}
			?>
		}
		.login #nav a, 
		.login #backtoblog a{
			color: <?php echo $contrast; ?>
		}
		<?php 
		endif;
		//CUSTOM LOGO
		if(has_custom_logo() AND $values['use_logo'] ): 
			$logo_image =  wp_get_attachment_image_url( get_theme_mod( 'custom_logo'));
		?>
		.login h1 a{
			background-image:url(<?php echo $logo_image ?>);
			width:auto;
			background-size:contain;
			margin:1em;
		}
		<?php endif; //custom logo 

		//CUSTOM HEADER
		if(has_header_image() AND $values['use_header'] ): 
			$header_image =  get_header_image();
		?>
		.login h1 {
			background-image:url(<?php echo $header_image ?>);
			width:auto;
			background-size:cover;
			background-position:center center;
			margin:0;
			padding:1px;
		}
		.login form{
			margin-top:0;
		}
		<?php endif; //custom logo 

		echo $values['custom_css'];
		?>


	</style>
	<?php
}

