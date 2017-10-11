<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://kodespace.com
 * @since      1.0.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
 * @author     cmroanirgo <cmroanirgo@users.noreply.github.com>
 */
class Epub_Reader_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
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
	}

}
