<?php

/**
 * Provides a public-facing view for the shortcode [epub-reader path='...']
 *
 *
 * @link       https://kodespace.com
 * @since      0.9.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/public/partials
 */

$epubsrc = plugin_dir_url( dirname(__FILE__) ).'views/epub-reader-frame.php?src='.urlencode($attributes['src']).'&v='.$attributes['version'].'&cv='.PLUGIN_NAME_VERSION;
$iframe_attr = '';
if (!empty($attributes['width']))
	$iframe_attr .= 'width="'.$attributes['width'].'" ';
if (!empty($attributes['height']))
	$iframe_attr .= 'height="'.$attributes['height'].'" ';
if (!empty($attributes['style']))
	$iframe_attr .= 'style="'.$attributes['style'].'" ';
if (!empty($attributes['class']))
	$iframe_attr .= 'class="'.$attributes['class'].'" ';
?>
<iframe class="epub-reader-frame" allowfullscreen="true" src="<?php echo $epubsrc; ?>" <?php echo $iframe_attr; ?>></iframe>