<div class="wrap">
	<h1>Instant Custom Login Form</h1>
	<form action="options.php" method="post">
		
		<?php settings_fields( 'ilc-login-settings' );	//pass slug name of page, also referred
		                                        //to in Settings API as option group name
		do_settings_sections( 'ilc-login-settings' ); 	//pass slug name of page
		submit_button();
		?>



		<!-- <?php 
		settings_fields('ilc_settings'); 
		$values = get_option('ilc_settings' );
		?>
		<input type="checkbox" name="ilc_settings[use-theme]" <?php checked(1, $values['use-theme'] ); ?>>
		<label>Use Theme's Custom Background, header and logo</label>
		<br>
		<label>Additional Custom CSS</label>
		<textarea name="ilc_settings[custom-css]"><?php echo $values['custom-css'] ?></textarea>
		<?php //submit_button('Save Changes' ); ?>
	-->
</form>
</div>