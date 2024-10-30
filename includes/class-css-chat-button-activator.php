<?php

/**
 * Fired during plugin activation
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 * @author     Atakan A. <atakanau@protonmail.com>
 */
class CSS_Chat_Button_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
/* 		$write_dirname = 'css-chat-btn';
		$upload_dir   = wp_upload_dir();
		$full_dirname = $upload_dir['basedir'].'/'.$write_dirname;

		if ( ! empty( $upload_dir['basedir'] ) && ! file_exists( $full_dirname ) ) {
			wp_mkdir_p( $full_dirname );
		} */

		require_once plugin_dir_path( __FILE__ ) . 'defaults.php';
		$option_key='css-chat-button'.'-settings';
		$settings = get_option( $option_key );
		if ( !$settings || $settings == '' ) {
			// There are no options set
			add_option( $option_key, $defaults );
		} elseif ( count( $settings ) == 0 ) {
			// All options are blank
			update_option( $option_key, $defaults );
		} else{
		}

		$plugin = new CSS_Chat_Button();
		$plugin->generate_content(false);
	}

}
