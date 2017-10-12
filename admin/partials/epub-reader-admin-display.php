<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://kodespace.com
 * @since      0.9.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/admin/partials
 */
?>
<style>
dl.epub-reader-dl dt { font-weight:bold;font-size:1.1em;margin-left:0.5em;}
span.epub-reader-sc { font-weight: bold; font-style:italic; font-size: 1.1em; }
</style>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2>ePub Reader Shortcode</h2>
<p>The following attributes can be specified in the shortcode <span class="epub-reader-sc">[epub-reader]</span>:</p>

<dl class='epub-reader-dl'>
	<dt>src</dt><dd>Defaults to 'epub/', which correlates to <em>http://&lt;wp-install-location&gt;/epub/</em>. Note that the path is <em>always</em> relative to the wordpress installation. Full URL's are not supported at this time.</dd>
	<dt>version</dt><dd>Set a <em>version</em> of the book. Major changes (eg new chapters) should increase this value. eg. <em>version="2-beta"</em>. <br/>
	Note: This has the effect of causing each user's individual reading position to be reset. However failure to do so will cause unexpected errors to the user's reading experience if the changes are large.</dd>
	<dt>width</dt><dd>Set the width of the widget. eg <em>width="300px"</em>.</dd>
	<dt>height</dt><dd>Set the height of the region. eg <em>height="480px"</em>.</dd>
	<dt>style</dt><dd>Set any css style on the region directly. eg <em>style="min-height:480px"</em>.</dd>
	<dt>class</dt><dd>Set any css class on the region. eg <em>class="some-ebook-class"</em>.</dd>
</dl>

<h3>Examples</h3>
<ol>
<li>[epub-reader src="uploads/Wuthering_Heights.epub"]. (Loads the compressed book from <em>http://&lt;wp-install-location&gt;/uploads/Wuthering_Heights.epub. Note this is very inefficient!</em>)</li>
<li>[epub-reader src="epubs/Wuthering_Heights/"]. (Loads from an unpacked epub <em>http://&lt;wp-install-location&gt;/epubs/Wuthering_Heights/</em>. This is the most efficient method)</li>
</ol>

<div id="wrap">
	<form method="post" action="options.php">
		<?php
			/*
			see also: EPub_Reader_Admin:register_settings() to reinstate settings
			settings_fields( 'epub-reader-settings' );
			do_settings_sections( 'epub-reader-settings' );
			submit_button();
			*/
		?>
	</form>
</div>