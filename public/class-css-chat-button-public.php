<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/public
 * @author     Atakan A. <atakanau@protonmail.com>
 */
class CSS_Chat_Button_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CSS_Chat_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CSS_Chat_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/css-chat-button-public.css', array(), $this->version, 'all' );

		$upload_dir   = wp_upload_dir();
		$style_file = '/css-chat-btn/s.css';

		$full_path = $upload_dir['basedir'].$style_file;
		if( ! empty( $upload_dir['basedir'] ) && file_exists( $full_path ) ) {
			wp_enqueue_style( $this->plugin_name.'-custom', $upload_dir['baseurl'].$style_file , array(), $this->version.'-'.dechex((int)((filemtime($full_path)-1682800000)/10 )), 'all' );
		}
		// else{
			// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/css-chat-button-public.css', array(), $this->version, 'all' );
		// }

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in CSS_Chat_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The CSS_Chat_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/css-chat-button-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Insert chat button html content before body end.
	 *
	 * @since    1.0.0
	 */
	public function insert_html(){
		$upload_dir   = wp_upload_dir();
		$read_dirname = 'css-chat-btn';
		$filename_html = 'generated.html';
		$full_dirname = $upload_dir['basedir'].'/'.$read_dirname;
		$full_path = $full_dirname.'/'.$filename_html;
		$html = "";
		if( ! empty( $full_dirname ) && file_exists( $full_path ) ) {
			$html = file_get_contents($full_path);
		}
		else{
			$plugin = new CSS_Chat_Button();
			$plugin->generate_content();
			if( ! empty( $full_dirname ) && file_exists( $full_path ) ) {
				$this->enqueue_styles();
				$html = file_get_contents($full_path);
			}
		}
		echo $html;
	}



}
