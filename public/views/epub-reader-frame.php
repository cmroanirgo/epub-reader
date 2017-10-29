<?php

// TODO: Check the referrer is set to the same domain (stopping hotlinking)
header('X-Frame-Options: SAMEORIGIN');

function getUrl() {
	$url = '';

	if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
	    $url .= 'https';
	else
	    $url .= 'http';

	$url .= '://';

	if (isset($_SERVER['HTTP_HOST']))
	    $url .= $_SERVER['HTTP_HOST'];
	elseif (isset($_SERVER['SERVER_NAME']))
	    $url .= $_SERVER['SERVER_NAME'];
	else
	    trigger_error ('Could not get URL from $_SERVER vars');


	if ($_SERVER['SERVER_PORT'] != '80')
	  $url .= ':'.$_SERVER["SERVER_PORT"];

	if (isset($_SERVER['REQUEST_URI']))
	    $url .= $_SERVER['REQUEST_URI'];
	elseif (isset($_SERVER['PHP_SELF']))
	    $url .= $_SERVER['PHP_SELF'];
	elseif (isset($_SERVER['REDIRECT_URL']))
	    $url .= $_SERVER['REDIRECT_URL'];
    return $url;	
}

$root_url = dirname(dirname(getUrl()));
$epubjs_url = $root_url.'/epubjs/';
$book_path = htmlspecialchars(urldecode($_GET["src"]));
$book_version = htmlspecialchars($_GET["v"]);
$book_zip = strstr($book_path, '.epub') || htmlspecialchars($_GET["zip"])=='1';
$cache_version = htmlspecialchars($_GET["cv"]);

?>
<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="robots" content="noindex, nofollow">

        <link rel="stylesheet" type="text/css" href="<?php echo $epubjs_url; ?>css/normalize.css?ver=<?php echo $cache_version; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $epubjs_url; ?>css/main.css?ver=<?php echo $cache_version; ?>">
        <!--<link rel="stylesheet" href="<?php echo $epubjs_url; ?>css/popup.css">-->
		<style type="text/css">
		@media print { 
			body * { display: none !important;}
			body:after { content: "WARNING:  UNAUTHORIZED USE AND/OR DUPLICATION OF THIS MATERIAL WITHOUT EXPRESS AND WRITTEN PERMISSION FROM THIS SITE'S AUTHOR AND/OR OWNER IS STRICTLY PROHIBITED! CONTACT US FOR FURTHER CLARIFICATION."; }
		}
		</style>
        <script src="<?php echo $epubjs_url; ?>js/libs/jquery.min.js?ver=<?php echo $cache_version; ?>"></script>

        <?php if ($book_zip) { ?>
        <script src="<?php echo $epubjs_url; ?>js/libs/zip.min.js?ver=<?php echo $cache_version; ?>"></script>
        <?php } ?>

        <script>
           "use strict";

           $(function() {
           		$('html').removeClass('no-js');
           		var $cont = $('#viewer-container');
           		var $view = $('#viewer');
           		function fixViewerSize() {
           			// remove accidental sub-pixel widths, which causes letters to be trimmed on RHS.
           			//console.log("Fixing size from: " + $cont.width() + " to " + Math.floor($cont.width()))
           			$view.width(Math.floor($cont.width()));
           		}
           		fixViewerSize();
           		$(window).resize(fixViewerSize).resize();
           })

           $(function() { 
           		if (self==top) {
           			// redirect to domain if NOT in an iframe!!
           			alert('Don\'t hotlink this book!')
           			window.location.href = "<?php echo $root_url; ?>";
           			return;
           		}

           		var isMobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Mobile|mobile|CriOS/i.test(navigator.userAgent));
           		var isAppleWebKit = (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1);
             	console.log("Using epub.js v" + EPUBJS.VERSION);
                console.log("Base uri: <?php echo $epubjs_url; ?>");
                console.log("isMobile: "+ isMobile+"       isAppleWebKit: " + isAppleWebKit);
                console.log('has localStorage: ' + (!!localStorage));
                EPUBJS.filePath = "<?php echo $epubjs_url; ?>js/libs/";
                EPUBJS.cssPath = "<?php echo $epubjs_url; ?>css/";
                EPUBJS.cacheVersion = "<?php echo $cache_version; ?>";
                EPUBJS.bookVersion = "<?php echo $book_version; ?>";

            	var cacheable = true; // window.location.href.search('http://localhost:8181')<0 && window.location.href.search('file://')<0;
            	var path = "<?php echo $book_path ?>"
        		console.info('cacheable: '+cacheable);
        		console.info('book path: '+path);
                var bookKey = path + '>v' + EPUBJS.bookVersion;
            	console.log("book key: "+bookKey);

            	var settings = {
                	restore: cacheable,
                	bookKey: bookKey
            	};
            	if (isAppleWebKit) { // add fixed layout settings for mobile
            		settings.width = $('#viewer').width();
            		settings.height = $('#viewer').height();
            		if (isMobile)
            			$('#fullscreen').hide(); // it doesn't work on mobile safari!
            	}

                window.reader = ePubReader(path, settings);
            	if (isAppleWebKit) {
            		$(window).on("orientationchange resize",function(){
            			console.log('rotated/resized')
            			
	            		setTimeout(function() { // give some time to settle before resizing fixed viewport area
	            			settings.width = $('#viewer').width();
		            		settings.height = $('#viewer').height();
		            		window.reader.book.renderer.resize(settings.width, settings.height, true);
		            		//console.log('window size is now: ' + settings.width + 'x' + settings.height)
	            		}, 100)
					});
            	}

            	var saveTimeout = -1;
            	var fnSaveSettings = function() {
            		if (saveTimeout>0)// cancel (& hence reset) any existing timeouts
            			clearTimeout(saveTimeout);
            		saveTimeout = setTimeout(function() {
            			//console.log('saving...')
            			saveTimeout = -1;
            			window.reader.saveSettings();
            		}, 1000);
            	}
            	window.reader.book.on('renderer:locationChanged', fnSaveSettings);
            	window.reader.on('reader:bookmarked', fnSaveSettings);
            	window.reader.on('reader:unbookmarked', fnSaveSettings);


				var fnNothing = function(e) { if (e) e.preventDefault(); return false; };
				var size=1.0;
				function redraw(_size) {
					size = _size;
					size = Math.min(2, Math.max(0.7, size))
					window.reader.book.setStyle("font-size", size+"em");
				}
				function fontSizeHandler(e, amt) {
					size += amt;
					redraw(size);
					return fnNothing(e);
				}
				$('#font-up').on('click', function(e) { return fontSizeHandler(e, 0.1); }).on('mousedown', fnNothing);
				$('#font-down').on('click', function(e) { return fontSizeHandler(e, -0.1); }).on('mousedown', fnNothing);
				$('#font-reset').on('click', function(e) { redraw(1); return fnNothing(e); }).on('mousedown', fnNothing);
				//$('#highlight').on('click', function(e) { return fnNothing(e); }).on('mousedown', fnNothing);
				$(document).on('touchmove', function(e) { e.preventDefault(); }); // fix iOS 10+ page scrolling

			})
        </script>

        <!-- File Storage -->
        <!--<script src="<?php echo $epubjs_url; ?>js/libs/localforage.min.js"></script>-->

        <!-- Full Screen -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/libs/screenfull.min.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Touch -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/libs/jquery.touchswipe.min.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Render -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/epub.min.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Hooks -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/hooks.min.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Reader -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/reader.min.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Protection -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/libs/protection.js?ver=<?php echo $cache_version; ?>"></script>
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/hooks/extensions/protection.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- misc -->
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/hooks/extensions/book_styles.js?ver=<?php echo $cache_version; ?>"></script>

        <!-- Highlights -->
        <!--
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/libs/jquery.highlight.js"></script>
        <script type="text/javascript" src="<?php echo $epubjs_url; ?>js/hooks/extensions/highlight.js"></script>-->

    </head>
    <body>
      <div id="main" class="flex vertical spaced">

        <div id="titlebar" class="flex spaced middle">
          <div id="opener" class="cell">
            <a id="menu" class="icon-menu" title="Menu">&nbsp;</a>
          </div>
          <div id="metainfo" class="cell">
            <span id="book-title"></span>
            <span id="title-seperator">&nbsp;–&nbsp;</span>
            <span id="chapter-title"></span>
          </div>
          <div id="title-controls" class="cell">
            <a id="font-up"   class="icon-font-up"       title="Increase Font">&nbsp;</a>
            <a id="font-down" class="icon-font-down"     title="Decrease Font">&nbsp;</a>
            <a id="bookmark" class="icon-bookmark-empty" title="Toggle Bookmark">&nbsp;</a>
            <a id="fullscreen" class="icon-resize-full"  title="Toggle Fullscreen">&nbsp;</a>
          </div>
        </div>
        <div id="_main" class="flex-grow">
	        <div id="divider"></div>
	        <div id="prev" class="arrow"><span>‹</span></div>
	        <div id="next" class="arrow"><span>›</span></div>
	        <div id="viewer-container">
	        	<div id="viewer"></div>
	        	<!--<div id="viewer-overlay"></div>-->
	    	</div>

	        <div id="loader"><img src="<?php echo $epubjs_url; ?>img/loader.gif"></div>
	     </div>
      </div>
      <div id="sidebar" class="flex vertical">
        <div id="sidebar-buttons">
          <a id="show-Toc" class="show_view icon-book active" data-view="Toc" title="Contents">&nbsp;</a>
          <a id="show-Bookmarks" class="show_view icon-bookmark" data-view="Bookmarks" title="Bookmarks">&nbsp;</a>
          <!--<a id="show-Notes" class="show_view icon-edit" data-view="Notes">&nbsp;</a>-->

          <a id="sidebar-closer" class="icon-cancel" title="Close">&nbsp;</a>
        </div>
        <div id="tocView" class="sidebar-panel">
        </div>
        <div id="bookmarksView" class="sidebar-panel">
          <ul id="bookmarks"></ul>
        </div>
        <!--<div id="notesView" class="view">
          <div id="new-note">
            <textarea id="note-text"></textarea>
            <button id="note-anchor">Anchor*</button>
            <p><em>* Click 'Anchor' and then click in the document on where you want the note to be.</em></p>
          </div>
          <ol id="notes"></ol>
        </div>-->
      </div>
      
    </body>
</html>
