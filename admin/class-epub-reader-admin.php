<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://kodespace.com
 * @since      0.9.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/admin
 * @author     cmroanirgo <cmroanirgo@users.noreply.github.com>
 */
class Epub_Reader_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.9.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init( $loader) {
		$loader->add_action( 'admin_menu', $this, 'register_settings_page' );// CM
		$loader->add_action( 'admin_init', $this, 'register_settings' ); // CM
		$loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
		$loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.9.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Epub_Reader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Epub_Reader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//if ( 'tools_page_epub-reader' != $hook )
		//	return;

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/epub-reader-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.9.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Epub_Reader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Epub_Reader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//if ( 'tools_page_epub-reader' != $hook )
		//	return;

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/epub-reader-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings page for the admin area.
	 *
	 * @since    0.9.0
	 */
	public function register_settings_page() {
		// Create our settings page as a submenu page.
		add_submenu_page(
			'tools.php',                             // parent slug
			__( 'ePub Reader', 'epub-reader' ),      // page title
			__( 'ePub Reader', 'epub-reader' ),      // menu title
			'manage_options',                        // capability
			'epub-reader',                           // menu_slug
			array( $this, 'display_settings_page' )  // callable function
		);
	}

	/**
	 * Display the settings page content for the page we have created.
	 *
	 * @since    0.9.0
	 */
	public function display_settings_page() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/epub-reader-admin-display.php';

	}


	/**
	 * Register the settings for our settings page.
	 *
	 * @since    0.9.0
	 */
	public function register_settings() {

		/*
		// Here we are going to register our setting.
		register_setting(
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings',
			array( $this, 'sandbox_register_setting' )
		);

		// Here we are going to add a section for our setting.
		add_settings_section(
			$this->plugin_name . '-settings-section',
			__( 'Settings', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_section' ),
			$this->plugin_name . '-settings'
		);

		// Here we are going to add fields to our section.
		add_settings_field(
			'post-types',
			__( 'Post Types', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_multiple_checkbox' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'post-types',
				'description' => __( 'Save button will be added only to the checked post types.', 'epub-reader' )
			)
		);
		add_settings_field(
			'toggle-content-override',
			__( 'Append Button', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_single_checkbox' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'toggle-content-override',
				'description' => __( 'If checked, it will append save button to the content.', 'epub-reader' )
			)
		);
		add_settings_field(
			'toggle-status-override',
			__( 'Membership', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_single_checkbox' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'toggle-status-override',
				'description' => __( 'If checked, this feature will be available only to logged in users. ', 'epub-reader' )
			)
		);
		add_settings_field(
			'toggle-css-override',
			__( 'Our Styles', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_single_checkbox' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'toggle-css-override',
				'description' => __( 'If checked, our style will be used.', 'epub-reader' )
			)
		);
		add_settings_field(
			'text-save',
			__( 'Save Item', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'text-save',
				'default'   => __( 'Save Item', 'epub-reader' )
			)
		);
		add_settings_field(
			'text-unsave',
			__( 'Unsave Item', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'text-unsave',
				'default'   => __( 'Unsave Item', 'epub-reader' )
			)
		);
		add_settings_field(
			'text-saved',
			__( 'Saved. See saved items.', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'text-saved',
				'default'   => __( 'Saved. See saved items.', 'epub-reader' )
			)
		);
		add_settings_field(
			'text-no-saved',
			__( 'You don\'t have any saved items.', 'epub-reader' ),
			array( $this, 'sandbox_add_settings_field_input_text' ),
			$this->plugin_name . '-settings',
			$this->plugin_name . '-settings-section',
			array(
				'label_for' => 'text-no-saved',
				'default'   => __( 'You don\'t have any saved items.', 'epub-reader' )
			)
		);
		*/
	}

	/**
	 * Sandbox our settings.
	 *
	 * @since    0.9.0
	 */
	public function sandbox_register_setting( $input ) {

		$new_input = array();

		if ( isset( $input ) ) {
			// Loop trough each input and sanitize the value if the input id isn't post-types
			foreach ( $input as $key => $value ) {
				if ( $key == 'post-types' ) {
					$new_input[ $key ] = $value;
				} else {
					$new_input[ $key ] = sanitize_text_field( $value );
				}
			}
		}

		return $new_input;

	}

	/**
	 * Sandbox our section for the settings.
	 *
	 * @since    0.9.0
	 */
	public function sandbox_add_settings_section() {

		return;

	}

	/**
	 * Sandbox our single checkboxes.
	 *
	 * @since    0.9.0
	 */
	public function sandbox_add_settings_field_single_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = 0;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>

			<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>">
				<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" <?php checked( $option, true, 1 ); ?> value="1" />
				<span class="description"><?php echo esc_html( $field_description ); ?></span>
			</label>

		<?php

	}

	/**
	 * Sandbox our multiple checkboxes
	 *
	 * @since    0.9.0
	 */
	public function sandbox_add_settings_field_multiple_checkbox( $args ) {

		$field_id = $args['label_for'];
		$field_description = $args['description'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = array();

		if ( ! empty( $options[ $field_id ] ) ) {
			$option = $options[ $field_id ];
		}

		if ( $field_id == 'post-types' ) {

			$args = array(
				'public' => true
			);
			$post_types = get_post_types( $args, 'objects' );

			foreach ( $post_types as $post_type ) {

				if ( $post_type->name != 'attachment' ) {

					if ( in_array( $post_type->name, $option ) ) {
						$checked = 'checked="checked"';
					} else {
						$checked = '';
					}

					?>

						<fieldset>
							<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>">
								<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $post_type->name . ']'; ?>" value="<?php echo esc_attr( $post_type->name ); ?>" <?php echo $checked; ?> />
								<span class="description"><?php echo esc_html( $post_type->label ); ?></span>
							</label>
						</fieldset>

					<?php

				}

			}

		} else {

			$field_args = $args['options'];

			foreach ( $field_args as $field_arg_key => $field_arg_value ) {

				if ( in_array( $field_arg_key, $option ) ) {
					$checked = 'checked="checked"';
				} else {
					$checked = '';
				}

				?>

					<fieldset>
						<label for="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>">
							<input type="checkbox" name="<?php echo $this->plugin_name . '-settings[' . $field_id . '][]'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . '][' . $field_arg_key . ']'; ?>" value="<?php echo esc_attr( $field_arg_key ); ?>" <?php echo $checked; ?> />
							<span class="description"><?php echo esc_html( $field_arg_value ); ?></span>
						</label>
					</fieldset>

				<?php

			}

		}

		?>

			<p class="description"><?php echo esc_html( $field_description ); ?></p>

		<?php

	}

	/**
	 * Sandbox our inputs with text
	 *
	 * @since    0.9.0
	 */
	public function sandbox_add_settings_field_input_text( $args ) {

		$field_id = $args['label_for'];
		$field_default = $args['default'];

		$options = get_option( $this->plugin_name . '-settings' );
		$option = $field_default;

		if ( ! empty( $options[ $field_id ] ) ) {

			$option = $options[ $field_id ];

		}

		?>
		
			<input type="text" name="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" id="<?php echo $this->plugin_name . '-settings[' . $field_id . ']'; ?>" value="<?php echo esc_attr( $option ); ?>" class="regular-text" />

		<?php

	}
}



