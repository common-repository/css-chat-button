<?php

/**
 * @link              https://atakanau.blogspot.com
 * @since             1.0.0
 * @package           CSS_Chat_Button
 *
 * @wordpress-plugin
 * Plugin Name:       CSS chat button
 * Plugin URI:        https://atakanau.blogspot.com/2023/05/css-chat-button-wp-plugin-whatsapp-free.html
 * Description:       Compact Simple Speedy chat button. It allows visitors to contact you via WhatsApp. Lightweight and fast loading for best SEO.
 * Version:           1.0.1
 * Author:            Atakan Au
 * Author URI:        https://atakanau.blogspot.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       css-chat-button
 * Domain Path:       /languages
 *
 * @license
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0-standalone.html
 * 
 * CSS chat button is distributed in the hope that it will be
 * useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
 * Public License for more details.
 *  
 * CSS chat button published under the GNU General Public License.
 * https://www.gnu.org/licenses/gpl-3.0-standalone.html.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'CSS_CHAT_BUTTON_VERSION', '1.0.1' );

if ( ! defined( 'CSS_CHAT_BUTTON_SUPPORT_LINK' ) ) {
	/**
	 * Resource version for busting cache.
	 *
	 * @since 1.0
	 */
	define( 'CSS_CHAT_BUTTON_SUPPORT_LINK', 'https://atakanau.blogspot.com/2023/05/css-chat-button-wp-plugin-whatsapp-free.html' );
}
if ( ! defined( 'CSS_CHAT_BUTTON_BASENAME' ) ) {
	/**
	 * URL to the plugin base name.
	 *
	 * @since 1.0
	 */
	define( 'CSS_CHAT_BUTTON_BASENAME', plugin_basename(__FILE__) );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-css-chat-button-activator.php
 */
function activate_css_chat_button() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-css-chat-button-activator.php';
	CSS_Chat_Button_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-css-chat-button-deactivator.php
 */
function deactivate_css_chat_button() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-css-chat-button-deactivator.php';
	CSS_Chat_Button_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_css_chat_button' );
register_deactivation_hook( __FILE__, 'deactivate_css_chat_button' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-css-chat-button.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_css_chat_button() {

	$plugin = new CSS_Chat_Button();
	$plugin->run();

}
run_css_chat_button();

/*
 *  Displays update information for a plugin. 
 */
function aax_update_message_css_chat_button($data, $response) {
	if (isset($data['upgrade_notice'])) {
		$msg = str_replace(array('<li>Warning', '<li>Info', '<p>', '</p>'), array('<li>🛑 ⚠️ Warning', '<li>ℹ️ Info', '<div>', '</div>'), $data['upgrade_notice']);
		echo '<style type="text/css">
			#css-chat-button-update .update-message p:last-child{ display:none;}
			#css-chat-button-update ul{ list-style:disc; margin-left:30px;}
			.wf-update-message{ padding-left:30px;}
			</style>
			<div class="update-message wf-update-message">' . wpautop($msg) . '</div>';
	}
}
add_action('in_plugin_update_message-'.CSS_CHAT_BUTTON_BASENAME, 'aax_update_message_css_chat_button', 10, 2);

