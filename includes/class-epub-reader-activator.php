<?php

/**
 * Fired during plugin activation
 *
 * @link       https://kodespace.com
 * @since      0.9.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.9.0
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
 * @author     cmroanirgo <cmroanirgo@users.noreply.github.com>
 */
class Epub_Reader_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.9.0
	 */
	public static function activate() {
		require_once 'class-epub-reader-posttype.php';
		$pt = new Epub_Reader_PostType();
		$pt->register_post_type();

		// Page Arguments
		$page_args = array(
			'post_title'   => __( 'ebook Demo', 'ebook-demo' ),
			'post_content' => '[epub-reader src="wp-content/plugins/epub-reader/public/epubjs/ebook"]',
			'post_status'  => 'publish',
			'post_type'    => EPUB_READER_POSTTYPE
		);
		// Insert the page and get its id.
		$_page_id = wp_insert_post( $page_args );
		// Save page id to the database.
		add_option( 'epub_reader_page_id', $_page_id );

		flush_rewrite_rules();
	}

	/**
	 * Called when the plugin is deactivated.
	 *
	 * @since    0.9.0
	 */
	public static function deactivate() {
	// Get Saved page id.
		$_page_id = get_option( 'epub_reader_page_id' );

		// Check if the saved page id exists.
		if ( $_page_id ) {

			// Delete saved page.
			wp_delete_post( $_page_id, true );

			// Delete saved page id record in the database.
			delete_option( 'epub_reader_page_id' );

		}
		flush_rewrite_rules();
	}

	/**
	 * Called when the plugin is updated.
	 *
	 * @since    0.9.19
	 */
	public static function updated() {
		if ( function_exists('wp_cache_flush') )
			wp_cache_flush();

		if ( function_exists('w3tc_pgcache_flush') )
			w3tc_pgcache_flush();

		if ( function_exists('wp_cache_clear_cache') )
			wp_cache_clear_cache();
	}
}
