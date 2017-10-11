=== ePub Reader ===
Contributors: cmroanirgo
Donate link: https://kodespace.com
Tags: 
Requires at least: 3.0.1
Tested up to: 4.8.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An ePub Reader for your WordPress posts and pages. 

== Description ==

An ePub Reader for WordPress. This plugin provides a simple shortcode entry as well as a custom post type to give you control over how the epub is displayed.

The underlying code uses a fork of the framework provided by [Futurepress' epub.js](https://github.com/futurepress/epub.js). Because of this, there is minimal IE support unfortunately.

=== Short Code ===

Just drop in the shortcode into your blog posts or pages to embed an iFrame with fullscreen reader capabilities.

eg.

`[epub-reader path="some/path.epub" width="640" height="480"]`


=== Custom Post Type ===

In the admin area, you'll see 'ePub Reader Pages' which are pages that are designed to give a full-browser view of the epub. These pages are largely theme-indepdendant.


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `epub-reader.zip` to the `/wp-content/plugins/` directory and unzip it.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[epub-reader path="some/path.epub"]` in your posts or pages, OR you can also use 'ePub Reader Pages'

== Frequently Asked Questions ==

= Does it have full browser support? =

Unfortunately, the underlying epub.js library has [several known IE incompatibilities](https://github.com/futurepress/epub.js#internet-explorer). However, in general the plugin should work on most modern browsers and phones without issue.

= Does it support mobile devices? = 

Yes. Although there may be some issues, the plugin is responsive in design and reflows accordingly.


== Screenshots ==

!https://kodespace.com/epub-reader/images/screenshot1.png!

== Changelog ==

= 1.0 =
* Initial Release

== Upgrade Notice ==

== Thanks ==

Thanks to:

* [Futurepress' epub.js](https://github.com/futurepress/epub.js)
