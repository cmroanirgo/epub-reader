<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://kodespace.com
 * @since      1.0.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<p>This is the epub settings page.</p>

<p>Have a look at the demo page created automatically. It's called 'ebook Demo' and shows you how to using this plugin.</p>
<p>If you have multiple ebooks to display, create a new page for each one and add the [epub-reader] shortcode to it.</p>

<h2>Shortcode</h2>
<p>The following parameters can be specified to the shortcode [epub-reader]:</p>

<dl>
	<dt>src</dt><dd>Defaults to 'epub/', which correlates to <em>http://&lt;wp-install-location&gt;/epub/</em>. Note that the path is <em>always</em> relative to the wordpress installation. Full URI's are not supported at this time.</dd>
</dl>

<h3>Examples</h3>
<ol>
<li>[epub-reader src="uploads/Wuthering_Heights.epub"]. (Loads the compressed book from <em>http://&lt;wp-install-location&gt;/uploads/Wuthering_Heights.epub. Note this is very inefficient!</em>)</li>
<li>[epub-reader src="epubs/Wuthering_Heights/"]. (Loads from an unpacked epub <em>http://&lt;wp-install-location&gt;/epubs/Wuthering_Heights/</em>. This is the most efficient method)</li>
</ol>

<div id="wrap">
	<form method="post" action="options.php">
		<?php
			settings_fields( 'epub-reader-settings' );
			do_settings_sections( 'epub-reader-settings' );
			submit_button();
		?>
	</form>
</div>