<div class="wrap">
	<h1>Instant Custom Login Form</h1>
	<form action="options.php" method="post">
		
		<?php 
		settings_fields('ilc_settings'); 
		$values = get_option('ilc_settings' );
		?>
		
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label>Theme Customizer</label>
					</th>
					<td>
					<p class="description">Check these options if you're trying to make your login form match your theme customizations</p>
					<fieldset>
						<input value="1" type="checkbox" name="ilc_settings[use_background]" <?php checked(1, $values['use_background'] ); ?>>
						<label>Use Theme's Custom Background</label>
						<br>
						<input value="1" type="checkbox" name="ilc_settings[use_logo]" <?php checked(1, $values['use_logo'] ); ?>>
						<label>Use Theme's Custom Logo</label>
						<br>
						<input value="1" type="checkbox" name="ilc_settings[use_header]" <?php checked(1, $values['use_header'] ); ?>>
						<label>Use Theme's Custom Header</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label>Optional Templates</label>
					</th>
					<td>
						<select name="ilc_settings[css_theme]">
							<option>WordPress Default</option>
							<option value="material" <?php 	selected( 'material', $values['css_theme'] ); ?>>Material</option>
							<option value="dark">Dark</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label>Additional Login CSS</label>
					</th>
					<td>
						<textarea name="ilc_settings[custom_css]" class="large-text code" rows="10"><?php echo $values['custom_css'] ?></textarea>
					</td>
				</tr>
				
			</tbody>
		</table>
		
		<br>
		
		
		<?php submit_button('Save &amp; Preview' ); ?>
	</form>


	<h1>Preview:</h1>
	<iframe style="border:solid 1px #ccc" src="<?php echo plugins_url( 'preview.php', __FILE__ ); ?>"
	width="700" height="600"></iframe>
</div>