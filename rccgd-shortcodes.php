<?php
/**
 * Plugin Name: RCCGD Shortcodes
 * Plugin URI: https://rccgraphicdesigns.com/
 * Description: Adds several shortcodes which enables you to output text strings anywhere you like.
 * Version: 1.0.0
 * Author: Konstantin Uvarov
 * Author URI: https://rccgraphicdesigns.com/
 */
 
/** Make sure we don't expose any info if called directly */
if ( ! defined( 'ABSPATH' ) ) exit;

/** This action registers the menu function using the admin_menu action hook */
add_action( 'admin_menu', 'rccgd_shortcodes_menu' );

/** This function contains the menu-building code */
function rccgd_shortcodes_menu() {
	add_options_page( 'RCCGD Shortcodes Options', 'RCCGD Shortcodes', 'manage_options', 'rccgd-shortcodes-options', 'rccgd_shortcodes_options' );
	add_action( 'admin_init', 'register_rccgd_shortcodes_options' ); //call register settings function
}

/** This function registers our settings */
function register_rccgd_shortcodes_options() {
	register_setting( 'rccgd-shortcodes-options-group', 'rccgd_name' );
	register_setting( 'rccgd-shortcodes-options-group', 'rccgd_type' );
	register_setting( 'rccgd-shortcodes-options-group', 'rccgd_details' );
}

/** HTML output for the page displayed when the menu item is clicked */
function rccgd_shortcodes_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
?>
<div class="wrap">
<h1>RCCGD Shortcodes</h1>
<p>Please fill in the boxes below and click Save Changes</p>
<form method="post" action="options.php">
    <?php settings_fields( 'rccgd-shortcodes-options-group' ); ?>
    <?php do_settings_sections( 'rccgd-shortcodes-options-group' ); ?>
	
<div id="poststuff">
	<div id="post-body" class="metabox-holder columns-2">
		<div id="post-body-content">
			<table class="form-table rccgd-shortcodes-table">
				<tr valign="top">
				<th scope="row">Name</th>
				<td><input type="text" name="rccgd_name" value="<?php echo esc_attr( get_option('rccgd_name') ); ?>"/></td>
				</tr>
				 
				<tr valign="top">
				<th scope="row">Type</th>
				<td>
					<select name="rccgd_type">
					  <option value="Apple" <?php selected(get_option('rccgd_type'), "Apple"); ?>>Apple</option>
					  <option value="Banana" <?php selected(get_option('rccgd_type'), "Banana"); ?>>Banana</option>
					  <option value="Orange" <?php selected(get_option('rccgd_type'), "Orange"); ?>>Orange</option>
					</select>
				</td>
				</tr>
				
				<tr valign="top">
				<th scope="row">Details</th>
				<td>
					<textarea name="rccgd_details" rows="10" cols="60"><?php echo esc_attr( get_option('rccgd_details') ); ?></textarea>
				</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</div><!-- #post-body-content -->
		<div id="postbox-container-1" class="postbox-container">
			<div id="informationdiv" class="postbox rccgd-shortcodes-info">
			<h3>How to use this plugin?</h3>
				<div class="inside">
					<p>You can use WordPress shortcodes to display options from this page on pages or posts:</p>
					<ul>
						<li>For the Name field:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[rccgd-shortcodes option=&quot;name&quot;]" class="large-text code"></span></li>
						<li>For the Type field:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[rccgd-shortcodes option=&quot;type&quot;]" class="large-text code"></span></li>
						<li>For the Details text area:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[rccgd-shortcodes option=&quot;details&quot;]" class="large-text code"></span></li>
					</ul><br>
					<p>If you want to use these options in your theme template files, you should use this code:</p>
					<ul>
						<li>For the Name field:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="<?php echo '<?php echo do_shortcode(&#039;[rccgd-shortcodes option=&quot;name&quot;]&#039;); ?>'  ?>" class="large-text code"></span></li>
						<li>For the Type field:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="<?php echo '<?php echo do_shortcode(&#039;[rccgd-shortcodes option=&quot;type&quot;]&#039;); ?>'  ?>" class="large-text code"></span></li>
						<li>For the Details text area:<br><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="<?php echo '<?php echo do_shortcode(&#039;[rccgd-shortcodes option=&quot;details&quot;]&#039;); ?>'  ?>" class="large-text code"></span></li>
					</ul>
				</div>
			</div><!-- #informationdiv -->
		</div><!-- #postbox-container-1 -->
	</div><!-- #post-body -->
<br class="clear">
</div><!-- #poststuff -->
</form>
</div><!-- .wrap -->
<?php }

/** We need some CSS to customize our fields */
function rccgd_shortcodes_css() {
	echo "
	<style type='text/css'>
	.rccgd-shortcodes-table input, .rccgd-shortcodes-table textarea {
		width: 100%;
	}
	.rccgd-shortcodes-info input {
		font-size: 12px;
	}
	</style>
	";
}
add_action( 'admin_head', 'rccgd_shortcodes_css' );

/** This creates a "[rccgd-shortcodes]" shortcode that displays our variables in front-end */
function rccgd_shortcodes_func( $atts ) {
	$a = shortcode_atts( array(
		'option' => '',
	), $atts );
	
	switch ($a['option']) {
		case "name":
			return get_option('rccgd_name');
		case "type":
			return get_option('rccgd_type');
		case "details":
			return get_option('rccgd_details');
	}
}
add_shortcode( 'rccgd-shortcodes', 'rccgd_shortcodes_func' );
?>