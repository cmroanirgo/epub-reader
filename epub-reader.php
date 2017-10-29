<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://kodespace.com
 * @since             0.9.0
 * @package           Epub_Reader
 *
 * @wordpress-plugin
 * Plugin Name:       ePub Reader
 * Plugin URI:        https://github.com/cmroanirgo/epub-reader
 * GitHub Plugin URI: cmroanirgo/epub-reader
 * Description:       An epub reader, mobile ready. Shortcode: [epub-reader src="/epubs/yourbook"].
 * Version:           0.9.24
 * Author:            Craig
 * Author URI:        https://kodespace.com/epub-reader
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       epub-reader
 * Domain Path:       /languages
 * Requires WP:       3.0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '0.9.24' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-epub-reader-activator.php
 */
function activate_epub_reader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-epub-reader-activator.php';
	Epub_Reader_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-epub-reader-deactivator.php
 */
function deactivate_epub_reader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-epub-reader-activator.php';
	Epub_Reader_Activator::deactivate();
}

/**
 * This code is called when *any* plugin is updated
 *
 * @since    0.9.19
 */

function updated_epub_reader( $upgrader_object, $options ) {
	$current_plugin_path_name = plugin_basename( __FILE__ );

	if ($options['action'] == 'update' && $options['type'] == 'plugin' ){
		foreach($options['plugins'] as $each_plugin){
			if ($each_plugin==$current_plugin_path_name){
				require_once plugin_dir_path( __FILE__ ) . 'includes/class-epub-reader-activator.php';
				Epub_Reader_Activator::updated();
			}
		}
	}

}

register_activation_hook( __FILE__, 'activate_epub_reader' );
register_deactivation_hook( __FILE__, 'deactivate_epub_reader' );
add_action( 'upgrader_process_complete', 'updated_epub_reader', 10, 2);


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-epub-reader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.9.0
 */
function run_epub_reader() {

	$plugin = new Epub_Reader();
	$plugin->run();

}
run_epub_reader();
