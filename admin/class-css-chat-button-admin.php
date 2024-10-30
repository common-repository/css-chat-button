<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CSS_Chat_Button
 * @subpackage CSS_Chat_Button/admin
 * @author     Atakan A. <atakanau@protonmail.com>
 */
class CSS_Chat_Button_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'plugin_action_links_' . $this->plugin_name . '/' . $this->plugin_name . '.php' , array($this, 'plugin_action_link') );
		add_filter('plugin_row_meta', array($this, 'plugin_meta_links'), 10, 2);

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/css-chat-button-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name. '-jqcp1', plugin_dir_url( __FILE__ ) . 'assets/jqcolorpicker/mod.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/css-chat-button-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name. '-jqcp1' , plugin_dir_url( __FILE__ ) . 'assets/jqcolorpicker/colors.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name. '-jqcp2', plugin_dir_url( __FILE__ ) . 'assets/jqcolorpicker/jqColorPicker.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name. '-jqcp3', plugin_dir_url( __FILE__ ) . 'assets/jqcolorpicker/index.js', array( 'jquery' ), $this->version, false );

	}

	#region options page >
	private $option_vals;

	public function add_admin_menu(  ) { 
		add_options_page(
			'CSS chat button Options', // page_title
			__( 'CSS chat button', $this->plugin_name ), // menu_title
			'manage_options', // capability
			'css-chat-button-options', // menu_slug
			array( $this, 'options_page' ) // function
		);
	}

	public function settings_section_callback(  ) { 
		printf(
			'%s. <a target="_blank" href="%s">%s</a>',
			__( 'WhatsApp floating chat button plugin for WordPress', $this->plugin_name ),
			CSS_CHAT_BUTTON_SUPPORT_LINK,
			__( 'Read more on blog', $this->plugin_name ),
		);
	}

	public function settings_init(  ) { 

		register_setting(
			'CSS_Chat_Button_OptPage', // option_group
			$this->plugin_name.'-settings', // option_name
			array( $this, 'options_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section', // id
			__( 'CSS chat button Options', $this->plugin_name ), // title h2
			array( $this, 'settings_section_callback' ), // callback
			'CSS_Chat_Button_OptPage' // page
		);

		add_settings_field(
			'chnl_wapp_id', // id
			__( 'WhatsApp Number', $this->plugin_name ), // title
			array( $this, 'option_channel_whatsapp_number_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field( 
			'glob_pos',  // id
			__( 'Button position', $this->plugin_name ),  // title
			array( $this, 'option_global_position_render' ), // callback
			'CSS_Chat_Button_OptPage',  // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field(
			'pad_b', // id
			__( 'Padding bottom', $this->plugin_name ), // title
			array( $this, 'option_css_pad_b_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field(
			'pad_l', // id
			__( 'Padding left', $this->plugin_name ), // title
			array( $this, 'option_css_pad_l_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field(
			'pad_r', // id
			__( 'Padding right', $this->plugin_name ), // title
			array( $this, 'option_css_pad_r_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field(
			'scale', // id
			__( 'Scale', $this->plugin_name ), // title
			array( $this, 'option_css_scale_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field(
			'color', // id
			__( 'Colors', $this->plugin_name )
			.' <button class="colors0" type="button" title="'.__( 'Restore defaults', $this->plugin_name ).'"><span class="dashicons dashicons-undo" aria-hidden="true"></span></button>'
			.' <a href="'.__( 'https://atakanau.blogspot.com/2023/05/css-chat-button-wp-plugin-whatsapp-free.html', $this->plugin_name )
			.'?default_colors" title="'.__( 'What is the default colors?', $this->plugin_name ).'" target="_blank" class="tdl-none"><span class="dashicons dashicons-info" aria-hidden="true"></span></a>', // title
			array( $this, 'option_css_colorf_render' ), // callback
			'CSS_Chat_Button_OptPage', // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field( 
			'newtab',  // id
			__( 'Open link in new tab', $this->plugin_name ),  // title
			array( $this, 'option_newtab_render' ), // callback
			'CSS_Chat_Button_OptPage',  // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

		add_settings_field( 
			'chnl_wapp_lnk',  // id
			__( 'WhatsApp link type', $this->plugin_name ),  // title
			array( $this, 'option_channel_whatsapp_link_render' ), // callback
			'CSS_Chat_Button_OptPage',  // page
			$this->plugin_name.'-CSS_Chat_Button_OptPage_section' // section
		);

	}

	public function settings_changed($old_value, $new_value) {
		$plugin = new CSS_Chat_Button();
		$plugin->generate_content(true,$new_value);

	}

	public function options_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['chnl_wapp_id'] ) ) {
			$sanitary_values['chnl_wapp_id'] = sanitize_text_field( $input['chnl_wapp_id'] );
		}
		if ( isset( $input['chnl_wapp_lnk'] ) ) {
			$sanitary_values['chnl_wapp_lnk'] = sanitize_text_field( $input['chnl_wapp_lnk'] );
		}

		if ( isset( $input['glob_pos'] ) ) {
			$sanitary_values['glob_pos'] = sanitize_text_field( $input['glob_pos'] );
		}

		if ( isset( $input['pad_b'] ) ) {
			$sanitary_values['pad_b'] = (int) $input['pad_b'];
		}
		if ( isset( $input['pad_r'] ) ) {
			$sanitary_values['pad_r'] = (int) $input['pad_r'];
		}
		if ( isset( $input['pad_l'] ) ) {
			$sanitary_values['pad_l'] = (int) $input['pad_l'];
		}
		if ( isset( $input['scale'] ) ) {
			$sanitary_values['scale'] = (int) $input['scale'];
		}
		
		$regex_pttrn = '/^(\#[\da-f]{3}|\#[\da-f]{6})$/imx';
		$color_names = array(
			 'colorb'	=>'#25D366'
			,'colorf'	=>'#FFFFFF'
			,'colorbh'	=>'#103928'
			,'colorfh'	=>'#DCF8C6'
		);
		foreach($color_names as $color_name => $color_val){
			if ( isset( $input[$color_name] ) && preg_match($regex_pttrn, $input[$color_name]) ) {
				$sanitary_values[$color_name] = sanitize_text_field( $input[$color_name] );
			}
			else{
				$sanitary_values[$color_name] = $color_val;
			}
		}
		if ( isset( $input['colorh'] ) ) {
			$sanitary_values['colorh'] = (int) $input['colorh'];
		}

		if ( isset( $input['newtab'] ) ) {
			$sanitary_values['newtab'] = (int) $input['newtab'];
		}


		return $sanitary_values;
	}


	public function option_channel_whatsapp_number_render() {
		printf(
			'<input class="regular-text width12em" type="number" name="%s[chnl_wapp_id]" id="chnl_wapp_id" value="%s" step="1"> %s',
			$this->plugin_name.'-settings',
			isset( $this->option_vals['chnl_wapp_id'] ) ? esc_attr( $this->option_vals['chnl_wapp_id']) : '',
			__( 'Enter only the digits of the number, including the country code. Example: 15558881234', $this->plugin_name ),
		);
	}

	public function option_channel_whatsapp_link_render() {
		?> <select name="<?php echo $this->plugin_name.'-settings'; ?>[chnl_wapp_lnk]" id="chnl_wapp_lnk">
			<?php $selected = (isset( $this->option_vals['chnl_wapp_lnk'] ) && $this->option_vals['chnl_wapp_lnk'] === 'wam') ? 'selected' : '' ; ?>
			<option value="wam" <?php echo $selected; ?>><?php echo __( 'Universal link - https://wa.me/[number]', $this->plugin_name ); ?></option>
			<?php $selected = (isset( $this->option_vals['chnl_wapp_lnk'] ) && $this->option_vals['chnl_wapp_lnk'] === 'api') ? 'selected' : '' ; ?>
			<option value="api" <?php echo $selected; ?>><?php echo __( 'API - https://api.whatsapp.com/send?phone=[number]', $this->plugin_name ); ?></option>
			<?php $selected = (isset( $this->option_vals['chnl_wapp_lnk'] ) && $this->option_vals['chnl_wapp_lnk'] === 'web') ? 'selected' : '' ; ?>
			<option value="web" <?php echo $selected; ?>><?php echo __( 'Desktop - https://web.whatsapp.com/send?phone=[number]', $this->plugin_name ); ?></option>
		</select> <?php
	}

	public function option_global_position_render() {
		?> <fieldset><?php $checked = ( isset( $this->option_vals['glob_pos'] ) && $this->option_vals['glob_pos'] === 'bottom-left' ) ? 'checked' : '' ; ?>
		<label for="glob_pos-0" class="width12em"><input type="radio" name="<?php echo $this->plugin_name.'-settings'; ?>[glob_pos]" id="glob_pos-0" value="bottom-left" <?php echo $checked; ?>> <?php echo __( 'Bottom left', $this->plugin_name ); ?></label>
		<?php $checked = ( isset( $this->option_vals['glob_pos'] ) && $this->option_vals['glob_pos'] === 'bottom-right' ) ? 'checked' : '' ; ?>
		<label for="glob_pos-1"><input type="radio" name="<?php echo $this->plugin_name.'-settings'; ?>[glob_pos]" id="glob_pos-1" value="bottom-right" <?php echo $checked; ?>> <?php echo __( 'Bottom right', $this->plugin_name ); ?></label></fieldset> <?php
	}

	public function option_css_pad_b_render() {
		printf(
			'<input class="regular-text width12em" type="number" name="%s[pad_b]" id="pad_b" value="%s" step="1"> px',
			$this->plugin_name.'-settings',
			isset( $this->option_vals['pad_b'] ) ? esc_attr( $this->option_vals['pad_b']) : '',
		);
	}

	public function option_css_pad_l_render() {
		printf(
			'<input class="regular-text width12em" type="number" name="%s[pad_l]" id="pad_l" value="%s" step="1"> px',
			$this->plugin_name.'-settings',
			isset( $this->option_vals['pad_l'] ) ? esc_attr( $this->option_vals['pad_l']) : '',
		);
	}

	public function option_css_pad_r_render() {
		printf(
			'<input class="regular-text width12em" type="number" name="%s[pad_r]" id="pad_r" value="%s" step="1"> px',
			$this->plugin_name.'-settings',
			isset( $this->option_vals['pad_r'] ) ? esc_attr( $this->option_vals['pad_r']) : '',
		);
	}

	public function option_css_scale_render() {
		printf(
			'<input class="regular-text width12em" type="number" name="%s[scale]" id="scale" value="%s" min="0" max="100" step="1"> %% ( ≡ <span id="%s" data-full="50"></span>px )',
			$this->plugin_name.'-settings',
			isset( $this->option_vals['scale'] ) ? esc_attr( $this->option_vals['scale']) : '',
			$this->plugin_name.'-scale_px',
		);
	}

	public function option_css_colorf_render() {
		printf(
			__( 'Background', $this->plugin_name ) . ': '
			.'<input class="regular-text width7em clrpick" type="text" name="%s[colorb]" id="colorb" value="%s">'
			.'<span class="width4em dinline"> </span>'
			.__( 'Foreground', $this->plugin_name ) . ': '
			.'<input class="regular-text width7em clrpick" type="text" name="%s[colorf]" id="colorf" value="%s">'
			.'<span class="width4em dinline"> </span>'
			.'<input type="checkbox" name="%s[colorh]" id="colorh" value="1" %s> <label for="colorh">%s:</label>'
			.'<div class="hover_color">'
				.__( 'Background', $this->plugin_name ) . ': '
				.'<input class="regular-text width7em clrpick" type="text" name="%s[colorbh]" id="colorbh" value="%s">'
				.'<span class="width4em dinline"> </span>'
				.__( 'Foreground', $this->plugin_name ) . ': '
				.'<input class="regular-text width7em clrpick" type="text" name="%s[colorfh]" id="colorfh" value="%s">'
			.'</div>'
			,
			$this->plugin_name.'-settings',isset( $this->option_vals['colorb'] ) ? esc_attr( $this->option_vals['colorb']) : '#25D366',
			$this->plugin_name.'-settings',isset( $this->option_vals['colorf'] ) ? esc_attr( $this->option_vals['colorf']) : '#FFFFFF',
			$this->plugin_name.'-settings',( isset( $this->option_vals['colorh'] ) && $this->option_vals['colorh'] === 1 ) ? 'checked' : '',
			__( 'Change colors on mouse hover', $this->plugin_name ),
			$this->plugin_name.'-settings',isset( $this->option_vals['colorbh'] ) ? esc_attr( $this->option_vals['colorbh']) : '#103928',
			$this->plugin_name.'-settings',isset( $this->option_vals['colorfh'] ) ? esc_attr( $this->option_vals['colorfh']) : '#DCF8C6',
		);
	}

	public function option_newtab_render() {
		printf(
			'<input type="checkbox" name="%s[newtab]" id="newtab" value="1" %s> <label for="newtab">%s</label>',
			$this->plugin_name.'-settings',
			( isset( $this->option_vals['newtab'] ) && $this->option_vals['newtab'] === 1 ) ? 'checked' : '',
			__( 'Check for open chat link in new tab', $this->plugin_name ),
		);
	}

	public function options_page(  ) { 
		$this->option_vals = get_option( $this->plugin_name.'-settings' );

		?>
		<form action='options.php' method='post' class="<?php echo $this->plugin_name; ?>">

			<?php
			settings_fields( 'CSS_Chat_Button_OptPage' );
			do_settings_sections( 'CSS_Chat_Button_OptPage' );
			submit_button();
			?>

		</form>
		<?php	}
	#endregion options page .

	public function plugin_meta_links($links, $file){
		if ( $file == CSS_CHAT_BUTTON_BASENAME ) {
			$support_link = '<a target="_blank" href="'.CSS_CHAT_BUTTON_SUPPORT_LINK.'#comments">' . __(translate('Support')) . '</a>';
			$rate_link = '<a target="_blank" href="https://wordpress.org/plugins/css-chat-button/reviews/?filter=5#new-post">' . __(translate('Rate',$this->plugin_name)).' ★★★★★' . '</a>';
			$links[] = $support_link;
			$links[] = $rate_link;
		}
		return $links;
	}
	function plugin_action_link( $links ) {
		$settings_link = '<a href="' . esc_url( admin_url( '/options-general.php?page=css-chat-button-options' ) ) . '">' . __( 'Settings', 'textdomain' ) . '</a>';
		
		array_push($links, $settings_link); // array_unshift
	
		return $links;
	
	}


}
