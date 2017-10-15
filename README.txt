=== ePub Reader ===
Contributors: cmroanirgo
Donate link: https://kodespace.com
Tags: epub
Requires WP: 3.0.1
Tested up to: 4.8.2
Stable tag: master
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An ePub Reader for your WordPress posts and pages. 

== Description ==

An ePub Reader for WordPress. This plugin provides a simple shortcode entry as well as a custom post type to give you control over how the epub is displayed.

The underlying code uses a fork of the framework provided by [Futurepress' epub.js](https://github.com/futurepress/epub.js). 

=== Note ===

There are two ways this plugin can read an epub:

1. As an `.epub`. This is clearly the easiest way, just upload and link to the file directly. However, this is *not* the most efficient way for the user (because extra code is needed to download the whole epub in one go and the unzip it and *then* their browser can use it).
1. As an extracted `.epub`. Upload the epub as normal, but use an 'unzip' tool to extract the contents of the epub to files and folders on your server. This is the most efficient for the end user. (It also has the benefit of stopping 3rd parties easily downloading the whole book easily, if that's important to you). 


=== Short Code ===

Just drop in the shortcode into your blog posts or pages to embed an iFrame with fullscreen reader capabilities.

eg.

`[epub-reader src="some/path.epub" width="640" height="480"]`


=== Custom Post Type ===

In the admin area, you'll see 'ePub Reader Pages' which are pages that are designed to give a full-browser view of the epub. These pages are largely theme-indepdendant.


== Installation ==

This section describes how to install the plugin and get it working. Choose one method.


## Use Github Updater

If you have already installed [Github Updater](https://github.com/afragen/github-updater), then use that.

1. Open Github Updater settings and click the 'Install Plugin' tab.
2. Enter `cmroanirgo/epub-reader` as the Plugin URI and then Install.
3. Go to the Plugins screen and click __Activate__.

If you do not have [Github Updater](https://github.com/afragen/github-updater), then you may wish to do so. It is the recommended way to install and keep up-to-date.

### Upload

1. Download the latest [tagged archive](cmroanirgo/epub-reader/releases/latest) (choose the "zip" option).
2. Unzip the archive, rename the folder correctly to `epub-reader`, then re-zip the file.
3. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
4. Upload the zipped archive directly.
5. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest [tagged archive](cmroanirgo/epub-reader/releases/latest) (choose the "zip" option).
2. Unzip the archive, rename the folder to `epub-reader`.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

1. Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone https://github.com/cmroanirgo/epub-reader.git`

2. Go to the Plugins screen and click __Activate__.

== Usage ==

1. Place `[epub-reader src="some/path.epub"]` in your posts or pages, OR you can also use 'ePub Reader Pages'


== Frequently Asked Questions ==

= Does it have full browser support? =

Unfortunately, the underlying epub.js library has [several known IE incompatibilities](https://github.com/futurepress/epub.js#internet-explorer). However, in general the plugin should work on most modern browsers and phones without issue.

= Does it support mobile devices? = 

Yes. Although there may be some issues, the plugin is responsive in design and reflows accordingly.

= What shortcode options are there? =

The shortcode supports the following attributes:

1. src="path/to/epub". This is mandatory

== Screenshots ==

!https://kodespace.com/epub-reader/images/screenshot1.png!

== Changelog ==

= 0.9.1 =
* Updated README
* Fixed github repo location
* Added support for github updater

= 0.9.0 =
* Alpha Release

== Upgrade Notice ==

== Thanks ==

Thanks to:

* [Futurepress' epub.js](https://github.com/futurepress/epub.js)
