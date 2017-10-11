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
	}

}
