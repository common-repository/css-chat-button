<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/includes
 * @author     Atakan A. <atakanau@protonmail.com>
 */
class CSS_Chat_Button {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      CSS_Chat_Button_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CSS_CHAT_BUTTON_VERSION' ) ) {
			$this->version = CSS_CHAT_BUTTON_VERSION;
		} else {
			$this->version = '1.0.1';
		}
		$this->plugin_name = 'css-chat-button';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - CSS_Chat_Button_Loader. Orchestrates the hooks of the plugin.
	 * - CSS_Chat_Button_i18n. Defines internationalization functionality.
	 * - CSS_Chat_Button_Admin. Defines all hooks for the admin area.
	 * - CSS_Chat_Button_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-css-chat-button-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-css-chat-button-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-css-chat-button-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-css-chat-button-public.php';

		$this->loader = new CSS_Chat_Button_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the CSS_Chat_Button_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new CSS_Chat_Button_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new CSS_Chat_Button_Admin( $this->get_css_chat_button(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		#region options page >
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'settings_init' );

		$this->loader->add_filter( 'update_option_'.$this->plugin_name.'-settings', $plugin_admin, 'settings_changed', 10, 2 );
		#endregion options page .

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new CSS_Chat_Button_Public( $this->get_css_chat_button(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'insert_html' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_css_chat_button() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    CSS_Chat_Button_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function generate_content($overwrite=true,$new_value=false) {
		$read_dirname = plugin_dir_path( __DIR__ ) . 'public/partials/';
		$write_dirname = 'css-chat-btn';
		$filename_html = 'generated.html';
		$filename_css = 's.css';
		$upload_dir   = wp_upload_dir();
		$full_dirname = $upload_dir['basedir'].'/'.$write_dirname;

		if( ! empty( $upload_dir['basedir'] ) && ! file_exists( $full_dirname ) ){
			wp_mkdir_p( $full_dirname );
		}

		$settings = $new_value ? $new_value : maybe_unserialize( get_option( $this->plugin_name.'-settings' ) );
		require_once plugin_dir_path( __FILE__ ) . 'defaults.php';
		$settings = wp_parse_args( $settings, $defaults );

		if($overwrite || !file_exists( $full_dirname.'/'.$filename_html )){
			$my_theme = wp_get_theme();$theme_i = "?t=". ($my_theme->get('Template')?$my_theme->get('Template'):$my_theme->get('TextDomain')) . "&v=". $my_theme->get('Version');
			$content = sprintf(
							file_get_contents($read_dirname.$filename_html), // format
							$settings['glob_pos']=='bottom-right'?'':' pleft',
							'https://wa.me/'.$settings['chnl_wapp_id'],
							intval($settings['newtab'])?' target="_blank"':'',
							// $settings[''],
							CSS_CHAT_BUTTON_SUPPORT_LINK . $theme_i,
							__( 'WhatsApp floating chat button plugin for WordPress', $this->plugin_name ) . ' '. $my_theme->get('Name'),
						);
			file_put_contents($full_dirname.'/'.$filename_html, $content);
		}
		if($overwrite || !file_exists( $full_dirname.'/'.$filename_css )){
			$content = sprintf(
							file_get_contents($read_dirname.$filename_css), // format
							$settings['pad_b'],
							$settings['pad_r'],
							intval($settings['scale'])==100?'':'transform: scale('.($settings['scale']/100).');',
							$settings['pad_l'],
							$settings['colorf']?$settings['colorf']:'#FFFFFF',
							$settings['colorb']?$settings['colorb']:'#25D366',
							$settings['colorbh']?$settings['colorbh']:'#103928',
							$settings['colorfh']?$settings['colorfh']:'#DCF8C6',
							// $settings[''],
						);
			/* colorh. */
			if(intval($settings['colorh'])!=1)
			$content = preg_replace(sprintf('/%s.*?%s/s', preg_quote('colorh'), preg_quote('colorh.')), '', $content);
			$content = $this->rem_comments($content);
			file_put_contents($full_dirname.'/'.$filename_css, $content);
		}

	}
	public function rem_comments($source){

		//  a blank line, also treats white spaces/tabs 
		$source = preg_replace('!^[ \t]*/\*.*?\*/[ \t]*[\r\n]!s', '', $source);

		//  Removes single line '//' comments, treats blank characters
		$source = preg_replace('![ \t]*// .*[ \t]*[\r\n]!', "\n", $source);

		//  Strip blank lines
		$source = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $source);

		$source = preg_replace('#^\s*//.+$#m', "", $source);
		// / * comment * /
		$source = preg_replace('!/\*.*?\*/!s', '', $source);
		$source = preg_replace('/\n\s*\n/', "\n", $source);

		$source = str_replace( "\t" , '' , $source);
		$source = str_replace( "\n" , '' , $source);

		return $source;
	}

}
