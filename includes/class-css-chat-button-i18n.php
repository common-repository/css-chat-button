<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 * @author     Atakan A. <atakanau@protonmail.com>
 */
class CSS_Chat_Button_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'css-chat-button',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
