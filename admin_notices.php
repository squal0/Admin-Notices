<?php
/**
 * Plugin Name: Admin Notices
 * Plugin URI:  https://github.com/squal0/Admin-Notices
 * Description: create a list of custom notices via a settings page.
 * Version:     1.0
 * Author:      Rahim Terah 
 * Author URI:  http://example.com/
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl.html
 */

//register js css scripts
add_action('admin_init', 'wp_admin_notice_admin_init');
//setup admin setting menu
add_action('admin_menu', 'wp_admin_notice_setup_admin');
//inject admin notice
add_action('admin_notices','wp_admin_notice_inject_notice');

/**
 * Adds the action link to settings menu.
 * @param type $links
 * @param type $file
 * @return type
 */
function wp_admin_notice_add_quick_settings_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {

		$link = admin_url('options-general.php?page=' . plugin_basename(__FILE__));
		$dashboard_link = "<a href=\"{$link}\">".__('Settings')."</a>";
		array_unshift($links, $dashboard_link);

	}

	return $links;
}

/**
 * Init plugin and register js css scripts
 * @global string $wp_version
 */
function wp_admin_notice_admin_init() {

	wp_admin_notice_register_settings();

	global $wp_version;

	$color_picker = version_compare($wp_version, '3.5') >= 0 ? 'wp-color-picker' // new wordpress
			: 'farbtastic'; // old wordpress

	wp_enqueue_style($color_picker);
	wp_enqueue_script($color_picker);

	wp_register_script('simple_notice_admin', plugins_url("/js/admin_notices.js", __FILE__), array('jquery',), '1.0', true);
	wp_enqueue_script('simple_notice_admin');

}

/**
 * Inject notice to pages
 * @global string $pagenow current page,for example 'plugins.php'
 * @return type
 */

function wp_admin_notice_inject_notice() {

	global $pagenow;
	// This applies only for the live site.
	if ( defined( 'DOING_AJAX' ) || !is_admin()) {

		return;
	}

	echo get_wp_admin_notice_html();
}

/**
 * get notice html
 * @return string $html
 */
function get_wp_admin_notice_html(){
	$opts = wp_admin_notice_get_options();
	$current_date = date('Y-m-d');
	$current_role = current_user_can($opts['role']);
	$dismissible = 'notice is-dismissible';

	if($current_role && $opts['status'] && ($opts['end_date'] != $current_date) && ($opts['start_date'] == $current_date)){

		$notice = $opts['notice'] ? $opts['notice'] : '';
		$role = $opts['role'] ? $opts['role'] : 'administrator';
		$text_color = $opts['text_color'] ? $opts['text_color'] : '#444';
		$font_size = $opts['font_size'] ? $opts['font_size'] : '12px';
		$style = $opts['style'] ? $opts['style'] : 'notice-success';
		$start_date = $opts['start_date'] ? $opts['start_date'] : '';
		$end_date = $opts['end_date'] ? $opts['end_date'] : '';

		return "<div class='{$style} {$dismissible }' ><h4 style='color:{$text_color};font-size:{$font_size}'>{$notice}</h4>
		</div>";

	}

	return '';
}

/**
 * check the current user logged in to assign a role
 */

function restrictly_get_current_user_role() {
  if( is_user_logged_in() ) {
	$user = wp_get_current_user();
	$role = ( array ) $user->roles;
	return $role[0];
  } else {
	return false;
  }
 }

/**
 * setup admin menu
 */

function wp_admin_notice_setup_admin() {

	add_options_page('Admin Notices', 'Admin Notices', 'manage_options', __FILE__, 'wp_admin_notice_options_page');

	add_filter('plugin_action_links', 'wp_admin_notice_add_quick_settings_link', 10, 2);
}

/**
 * Sets the setting variables
 */

function wp_admin_notice_register_settings() { // whitelist options

	register_setting('wp_admin_notice_settings', 'wp_admin_notice_options', 'wp_admin_notice_validate_settings');
}

/**
 * This is called by WP after the user hits the submit button.
 * The variables are trimmed first and then passed to the who ever wantsto filter them.
 * @param array the entered data from the settings page.
 * @return array the modified input array
 */

function wp_admin_notice_validate_settings($input) { // whitelist options

	$input = array_map('trim', $input);

	// did the extension break stuff?
	$input = is_array($input_filtered) ? $input_filtered : $input;

	// for font size we want 12px
	if ($input['font_size']) {
		$input['font_size'] = preg_replace('#\s#si', '', $input['font_size']);
	}

	return $input;
}

/**
 * Retrieves the plugin options. It inserts some defaults.
 * The saving is handled by the settings page. Basically, we submit to WP and it takes care of the saving.
 * @return array $opts
 */

function wp_admin_notice_get_options() {

	$defaults = array(

		'status' => 0,
		'text_color' => '#444',
		'font_size' => '12px',
		'role' => 'administrator',
		'style' => 'notice-success',
		'start_date' => 'mm/dd/yyyy',
		'end_date' => 'mm/dd/yyyy',
		'notice' => 'Update WordPress today at 10am. Ensure to backup website.',
	);

	$opts = get_option('wp_admin_notice_options');

	$opts = (array) $opts;
	$opts = array_merge($defaults, $opts);

	return $opts;
}

/**
 * Options page
 */
function wp_admin_notice_options_page() {

	$opts = wp_admin_notice_get_options();
	global $wp_version;
	require dirname(__FILE__).'/options-page.php';
}

