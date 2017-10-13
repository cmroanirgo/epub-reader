/*
Copyright kodespace.com
*/
jQuery(document).ready(function()
{
	if (window.location.href.search('http://test.dev')>=0)
		return;
	console.log("copy protection enabled")
	jQuery(document).bind("cut copy paste",function(e) {
		e.preventDefault();
	});
	jQuery("html,body").on("contextmenu",function(e){
	    //if (window.location.href.search('http://test.dev')>=0)
	    //	return;
	    e.preventDefault();
		return false;
	});
	jQuery(window).keydown(function(e) { deKey('keydown', e); });
 	jQuery(window).keyup(function(e) { deKey('keyup', e); });

    var wasMetaKey = false;
	function deKey(name, e){
		if(e.which == 44){ // printscr
			e.preventDefault();
		}
		else if (e.metaKey) {
			e.preventDefault();
			e.stopPropagation();
	        wasMetaKey = true;
		}
		else if (wasMetaKey) {
			e.preventDefault();
			e.stopPropagation();
			wasMetaKey = false;
		}
    }
});


