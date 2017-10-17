<?php
/**
 * The template for displaying epub pages. 
 * It's just a basic WP page with only wp_head()/wp_footer() & content, without menus, etc
 *	Note: the epub only works when the content encounters the [epub-reader] shortcode
 *
 * This is the template that displays all epub pages by default.
 */
//define('DONOTCACHEPAGE', true); // disable WP Super Cache & company for this page. 

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js epub-reader-html">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="robots" content="noindex, nofollow">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class("epub-reader-body"); ?>>

<?php
// Start the loop.
while ( have_posts() ) : the_post();

	// Execute the page content template (which'll have our shortcode).
	the_content();

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

// End the loop.
endwhile;


/**Footer*/
 wp_footer(); 

?>
</body>
</html>
