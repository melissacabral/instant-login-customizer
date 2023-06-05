<?php 
/**
 * A sample login form to display a preview in Instant Login Customizer. Not a functional login form
 */
/* Short and sweet */
define('WP_USE_THEMES', false);
require('../../../wp-blog-header.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo admin_url(); ?>/load-styles.php?c=0&amp;dir=ltr&amp;load%5B%5D=dashicons,buttons,forms,l10n,login">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&amp;lsubset=latin%2Clatin-ext&amp;lver=4.5.3">
	<?php do_action('login_head' ); ?>
</head>

<body class="login login-action-login wp-core-ui  locale-en-us">
	<div id="login">
		<h1><a href="#" title="Custom Logo" tabindex="-1"><?php bloginfo( 'name' ) ?></a></h1>

		<form name="loginform" id="loginform">
			<p>
				<label for="user_login">Username or Email<br />
					<input type="text" class="input"  size="20" value="User Name" />
				</label>
			</p>
			<p>
				<label for="user_pass">Password<br />
					<input type="password" class="input"  size="20" value="password" />
				</label>
			</p>
			<p class="forgetmenot">
				<label for="rememberme">
					<input type="checkbox" checked /> Remember Me
				</label>
			</p>
			<p class="submit">
				<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In" />
			</p>
		</form>

		<p id="nav">
			<a href="#">Lost your password?</a>
		</p>

		<p id="backtoblog"><a href="#">&larr; Back to <?php bloginfo( 'name' ) ?></a></p>

	</div>
</body>
</html>