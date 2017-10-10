<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://kodespace.com
 * @since      1.0.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/public
 * @author     Craig <x@x.com>
 */
class Epub_Reader_Public {

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

	public function init( $loader ) {
		// Add our Shortcode
		$loader->add_shortcode( EPUB_READER_SHORTCODE, $this, 'epub_reader_shortcode' );
		$loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/epub-reader-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$epubjs_url = plugin_dir_url( __FILE__ ) . 'epubjs/';
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/epub-reader-public.js', array( 'jquery' ), $this->version, false );
		wp_register_script( $this->plugin_name . '-fs'     , $epubjs_url . 'js/libs/screenfull.min.js', array(  ), $this->version, false);
		wp_register_script( $this->plugin_name . '-epub-js', $epubjs_url . 'js/epub.min.js', array(  ), $this->version, false);
		wp_register_script( $this->plugin_name . '-hooks'  , $epubjs_url . 'js/hooks.min.js', array(  ), $this->version, false);
		wp_register_script( $this->plugin_name . '-reader' , $epubjs_url . 'js/reader.min.js', array(  ), $this->version, false);
		wp_register_script( $this->plugin_name . '-zip' , $epubjs_url . 'js/libs/zip.min.js', array(  ), $this->version, false);

	}


	/**
	 * Create Shortcode .
	 *
	 * @since    1.0.0
	 */
	public function epub_reader_shortcode($user_defined_attributes, $content, $shortcode_name) {
		$epubjs_url = plugin_dir_url( __FILE__ ) . 'epubjs/';

		$attributes = shortcode_atts(
				array(
					'path' => 'epub/',
					'version' => '1',
					'class'  => '',
					'style' => '',
					'zip' => '',
				),
				$user_defined_attributes,
				EPUB_READER_SHORTCODE
			);

		// do the processing
		if (empty( $attributes['path'] ))
			die ('path parameter to shortcode epub-reader must NOT be empty!');
		
		$attributes['path'] = '/'.ltrim($attributes['path'], '/'); // ensure absolute path
		if ( strstr($attributes['path'], '.epub'))
			$attributes['zip'] = 'true';
		else
			$attributes['path'] = rtrim($attributes['path'], '/') . '/'; // ensure non-epubs end with a folder sep

		if (!empty( $attributes['zip'] ))
			$attributes['zip'] = true; // enforce boolean


		wp_enqueue_style( $this->plugin_name);
		//wp_enqueue_script( $this->plugin_name);
		wp_enqueue_script( $this->plugin_name . '-fs'     );
		wp_enqueue_script( $this->plugin_name . '-epub-js');
		wp_enqueue_script( $this->plugin_name . '-hooks'  );
		wp_enqueue_script( $this->plugin_name . '-reader' );
		if ($attributes['zip']) 
			// add zip script if we're dealing directly with an .epub
			wp_enqueue_script( $this->plugin_name . '-zip' );


		// Call the view file, capture it into the output buffer, and then return it.
		ob_start();
		require plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/epub-reader-public-shortcode.php';
		return ob_get_clean();

	}


}
