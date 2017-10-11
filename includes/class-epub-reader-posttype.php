<?php
/**
 * Register all actions and filters for the plugin
 *
 * @link       https://kodespace.com
 * @since      0.9.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
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
 * @since      0.9.0
 * @package    Epub_Reader
 * @subpackage Epub_Reader/includes
 * @author     cmroanirgo <cmroanirgo@users.noreply.github.com>
 */
class Epub_Reader_PostType {
	
	public function init($loader) { //$loader is EPub_Reader_Loader
		$loader->add_action( 'init', $this, 'register_post_type' );
		$loader->add_filter( 'default_content', $this, 'set_default_content', 10, 2 );
		$loader->add_filter( 'single_template', $this, 'filter_page_template');
		$loader->add_filter( 'page_template', $this, 'filter_page_template' );
	}

	public function register_post_type() {

		$args = array (
			'label' => esc_html__( 'ePub Reader Pages', 'text-domain' ),
			'labels' => array(
				'menu_name' => esc_html__( 'ePub Reader Pages', 'text-domain' ),
				'name_admin_bar' => esc_html__( 'ePub Reader Page', 'text-domain' ),
				'add_new' => esc_html__( 'Add new', 'text-domain' ),
				'add_new_item' => esc_html__( 'Add new ePub Reader Page', 'text-domain' ),
				'new_item' => esc_html__( 'New ePub Reader Page', 'text-domain' ),
				'edit_item' => esc_html__( 'Edit ePub Reader Page', 'text-domain' ),
				'view_item' => esc_html__( 'View ePub Reader Page', 'text-domain' ),
				'update_item' => esc_html__( 'Update ePub Reader Page', 'text-domain' ),
				'all_items' => esc_html__( 'All ePub Reader Pages', 'text-domain' ),
				'search_items' => esc_html__( 'Search ePub Reader Pages', 'text-domain' ),
				'parent_item_colon' => esc_html__( 'Parent ePub Reader Page', 'text-domain' ),
				'not_found' => esc_html__( 'No ePub Reader Pages found', 'text-domain' ),
				'not_found_in_trash' => esc_html__( 'No ePub Reader Pages found in Trash', 'text-domain' ),
				'name' => esc_html__( 'ePub Reader Pages', 'text-domain' ),
				'singular_name' => esc_html__( 'ePub Reader Page', 'text-domain' ),
			),
			'public' => true,
			'description' => 'Pages for an epub reader',
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => false,
			'show_in_rest' => false,
			'menu_position' => 11,
			'menu_icon' => 'dashicons-book-alt',
			'capability_type' => 'post',
			'hierarchical' => false,
			'has_archive' => false,
			'query_var' => true,
			'can_export' => true,
			'rewrite_slug' => 'ebook',
			'rewrite_no_front' => true,
			'supports' => array(
				'title',
				'editor',
				//'custom-fields',
				'page-attributes',
			),
			'rewrite' => array(
				'slug' => 'ebook',
				'with_front' => false,
				'feeds' => true
			),
		);

		register_post_type( EPUB_READER_POSTTYPE, $args );

	// todo: http://blog.teamtreehouse.com/create-your-first-wordpress-custom-post-type

		/*
		if(false && function_exists("register_field_group"))
		{
			register_field_group(array (
				'id' => 'acf_epub',
				'title' => 'ePub',
				'fields' => array (
					array (
						'key' => 'field_59db6f6f41f50',
						'label' => 'Path',
						'name' => 'path',
						'type' => 'text',
						'instructions' => 'Select the path to the expanded epub, eg \'epubs/Wuthering_Heights/\'',
						'required' => 1,
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59db6fdc41f51',
						'label' => 'Allow Text Search',
						'name' => 'allow_text_search',
						'type' => 'true_false',
						'instructions' => '(Warning! Experimental)',
						'message' => '',
						'default_value' => 0,
					),
					array (
						'key' => 'field_59db7131fd7c3',
						'label' => 'Allow Highlighting',
						'name' => 'allow_highlighting',
						'type' => 'true_false',
						'instructions' => '(Warning! Experimental)',
						'message' => '',
						'default_value' => 0,
					),
					array (
						'key' => 'field_59db7150fd7c4',
						'label' => 'Allow Bookmarks',
						'name' => 'allow_bookmarks',
						'type' => 'true_false',
						'instructions' => '(Warning! Experimental)',
						'message' => '',
						'default_value' => 0,
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'epub-page',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'acf_after_title',
					'layout' => 'no_box',
					'hide_on_screen' => array (
						0 => 'the_content',
					),
				),
				'menu_order' => 1,
			));
		}*/
	}

	public function set_default_content($content, $post) { // from https://wordpress.stackexchange.com/a/26028
		if ($post->post_type == EPUB_READER_POSTTYPE)
			$content = '['.EPUB_READER_SHORTCODE.' src="/path/to/ebook/" width="100%" height="100%"]';

	    return $content;
	}


	/**
	 * Watch for our post_type & choose our page template (or use a global custom one if defined).
	 *
	 * @since    0.9.0
	 */
	public function filter_page_template( $page_template )
	{
		global $post;

     	if ($post->post_type == EPUB_READER_POSTTYPE ) {
	   	
			$single_postType_template = locate_template("single-epub-reader-page.php");
			if( file_exists( $single_postType_template ) )
			{
				return $single_postType_template;
			} 
			else 
			{
		        $page_template = dirname( __FILE__ ) . '/../public/views/epub-reader-template.php';
			}

	    }
	    return $page_template;
	}

}

