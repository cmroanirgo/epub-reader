<?php

/**
 * Provide a public-facing view for the shortcode [epub-reader path='...']
 *
 *
 * @link       https://kodespace.com
 * @since      1.0.0
 *
 * @package    Epub_Reader
 * @subpackage Epub_Reader/public/partials
 */
?>

       <script>
        	"use strict";
       		var $ = $ || jQuery;
          	jQuery(function() {
           		var $cont = $('#epub-reader #viewer-container');
           		var $view = $('#epub-reader #viewer');
           		function fixViewerSize() {
           			// remove accidental sub-pixel widths, which causes letters to be trimmed on RHS.
           			//console.log("Fixing size from: " + $cont.width() + " to " + Math.floor($cont.width()))
           			$view.width(Math.floor($cont.width()/2)*2);
           		}
           		fixViewerSize();
           		$(window).resize(fixViewerSize).resize();

             	console.log("Using epub.js v" + EPUBJS.VERSION);
                var base_uri = "<?php echo $epubjs_url; ?>";
                console.log("Base uri: "+base_uri);
                EPUBJS.filePath = base_uri+ "js/libs/";
                EPUBJS.cssPath = base_uri + "css/";


            	var cacheable = true; // window.location.href.search('http://localhost:8181')<0 && window.location.href.search('file://')<0;
            	var path = "<?php echo $attributes['path']; ?>"
            	var version = "<?php echo $attributes['version']; ?>"
        		console.info('cacheable: '+cacheable);
        		console.info('book path: '+path);
                var bookKey = EPUBJS.VERSION + ">"+path + '>v' + version;
            	console.log("book key: "+bookKey);

                //window.reader = ePubReader("ebook.epub");
                window.reader = ePubReader(path, {
                	restore: cacheable
                	, bookKey: bookKey
                });


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
				$('#highlight').on('click', function(e) { return fnNothing(e); }).on('mousedown', fnNothing);
			})
        </script>

        <!-- File Storage -->
        <!--<script src="js/libs/localforage.min.js"></script>-->

        <!-- Full Screen -->
<!--        <script type="text/javascript" src="js/libs/screenfull.min.js"></script> -->

        <!-- Render -->
<!--        <script type="text/javascript" src="js/epub.min.js"></script>-->

        <!-- Hooks -->
<!--        <script type="text/javascript" src="js/hooks.min.js"></script>-->

        <!-- Reader -->
<!--        <script type="text/javascript" src="js/reader.min.js"></script>-->

    <div id="epub-reader" <?php 
    		if (!empty($attributes['style'])) { echo " style=\"".$attributes['style']."\""; }
    		if (!empty($attributes['class'])) { echo " class=\"".$attributes['class']."\""; }
    	?>>
      <div id="sidebar">
        <div id="panels">
          <input id="searchBox" placeholder="search" type="search">

          <a id="show-Search" class="show_view icon-search" data-view="Search">&nbsp;</a>
          <a id="show-Toc" class="show_view icon-list-1 active" data-view="Toc" title="Contents">&nbsp;</a>
          <a id="show-Bookmarks" class="show_view icon-bookmark" data-view="Bookmarks" title="Bookmarks">&nbsp;</a>
          <a id="show-Notes" class="show_view icon-edit" data-view="Notes">&nbsp;</a>

        </div>
        <div id="tocView" class="view">
        </div>
        <div id="searchView" class="view">
          <ul id="searchResults"></ul>
        </div>
        <div id="bookmarksView" class="view">
          <ul id="bookmarks"></ul>
        </div>
        <div id="notesView" class="view">
          <div id="new-note">
            <textarea id="note-text"></textarea>
            <button id="note-anchor">Anchor*</button>
            <p><em>* Click 'Anchor' and then click in the document on where you want the note to be.</em></p>
          </div>
          <ol id="notes"></ol>
        </div>
      </div>
      <div id="main" class="flex vertical spaced">

        <div id="titlebar" class="flex spaced middle">
          <div id="opener" class="cell">
            <a id="slider" class="icon-menu" title="Menu">&nbsp;</a>
          </div>
          <div id="metainfo" class="cell">
            <span id="book-title"></span>
            <span id="title-seperator">&nbsp;–&nbsp;</span>
            <span id="chapter-title"></span>
          </div>
          <div id="title-controls" class="cell">
            <a id="font-up"   style="font-size:1.1em" title="Increase Font">A+</a>
            <a id="font-down" style="font-size:0.9em" title="Decrease Font">A-</a>
            <a id="font-reset"                       >F</a>
            <a id="highlight"                        >H</a>
            <a id="bookmark" class="icon-bookmark-empty" title="Toggle Bookmark">&nbsp;</a>
            <a id="setting" class="icon-cog"  title="Settings">&nbsp;</a>
            <a id="fullscreen" class="icon-resize-full"  title="Toggel Fullscreen">&nbsp;</a>
          </div>
        </div>
        <div id="_main" class="flex-grow">
	        <div id="divider"></div>
	        <div id="prev" class="arrow"><span>‹</span></div>
	        <div id="next" class="arrow"><span>›</span></div>
	        <div id="viewer-container">
	        	<div id="viewer"></div>
	    	</div>

	        <div id="loader"><img src="<?php echo $epubjs_url; ?>img/loader.gif"></div>
	     </div>
      </div>
      <div class="modal md-effect-1" id="settings-modal">
          <div class="md-content">
              <h3>Settings</h3>
              <div>
                  <p>
                    <input type="checkbox" id="sidebarReflow" name="sidebarReflow">Reflow text when sidebars are open.
                  </p>
              </div>
              <div class="closer icon-cancel-circled"></div>
          </div>
      </div>
      <!--<div class="overlay"></div>-->
</div>