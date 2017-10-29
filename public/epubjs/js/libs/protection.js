/*
Copyright kodespace.com
*/
jQuery(document).ready(function()
{
	var $ = jQuery;
	if (window.location.href.search('http://test.dev')>=0)
		return;
	//console.log("copy protection enabled")
	$('body').css({
			cursor: 'default', 
			'user-select': 'none',
			'-moz-user-select': 'none',
			'-webkit-user-select': 'none',
			'-ms-user-select': 'none'}
			);
	$(document).bind("cut copy paste",function(e) {
		e.preventDefault();
	});
	$("html,body").on("contextmenu",function(e){
	    e.preventDefault();
		return false;
	});
	$(window).keydown(function(e) { deKey('keydown', e); });
 	$(window).keyup(function(e) { deKey('keyup', e); });

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


