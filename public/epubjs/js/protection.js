$(function() {
	var active = !((window.location.href.search('http://localhost:8181')>=0 || window.location.href.search('file://')>=0))
	var copy_msg = "Do not copy this site's content!";

    var copyElement = document.createElement('input');      
    copyElement.setAttribute('type', 'text');   
    copyElement.setAttribute('value', copy_msg);    
    copyElement.setAttribute('style', 'position:absolute;left:-9999px')
    copyElement = document.body.appendChild(copyElement);   
    
    var wasMetaKey = false;
	function deKey(name, e){
 		//console.log(name + ' key:'+ e.which + ' m:' + e.metaKey + ' s:' + e.shiftKey + ' c:'+e.ctrlKey)
		if(e.which == 44){
			e.preventDefault();
	        deCopy(name + " prntscrn")
		}
		else if (e.metaKey) {
			e.preventDefault();
			e.stopPropagation();
	        wasMetaKey = true;
	        //deCopy(name + " meta dn")
		}
		else if (wasMetaKey) {
			e.preventDefault();
			e.stopPropagation();
			wasMetaKey = false;
	        deCopy(name + " meta up")
		}
    }

 	$(window).keydown(function(e) { deKey('keydown', e); });
 	$(window).keyup(function(e) { deKey('keyup', e); });

	// disable context menus & watch for iframe changes
	function disableDoc(doc) {
		if (!active)
			return;
		doc.addEventListener('copy', function(e){
		    try { e.clipboardData.setData("text/plain", copy_msg); } 
		    catch(e) { 
				console.log("Copy failed: " + e.toString())
		    }
		    e.preventDefault();
		})
		doc.addEventListener('click', function(e) { deCopy('click') })
		//doc.addEventListener('DOMActivate', function(e) { deCopy('DOMActivate') })
		//doc.addEventListener('visibilitychange', function(e) { deCopy('visibilitychange') })
		//doc.addEventListener('focusin', function(e) { deCopy('focusin') })
		//doc.addEventListener('focusout', function(e) { deCopy('focusout') })
		//doc.addEventListener('focus', function(e) { deCopy('focus') })
		//doc.addEventListener('blur', function(e) { deCopy('blur') })
	    doc.oncontextmenu = function(e) { if (e) e.preventDefault(); return false; };
	}
	disableDoc(document);

	function deCopy(name) { 
		//console.log("event: " + name)
		try {
			copyElement.select();
		    document.execCommand('copy');   
		    copyElement.blur();
			//console.log(name + ' ok')
		}	
		catch(e) {
			//console.log(name + ' failed: ' + e.toString())
		}		
	}
	var cpProt = false && setInterval(function(){
		$("#titlebar").click(); 
		},1000);

	var MutationObserver   = window.MutationObserver || window.WebKitMutationObserver;
	if (!!MutationObserver) return; // IE10, Opera Mini
	var _observer          = new MutationObserver(mutationHandler);

	$(document).each ( function () {
	    _observer.observe(this, { childList: true, characterData:true, attributes:true, subtree: true });
	} );

	function mutationHandler (mutationRecords) {

	    mutationRecords.forEach ( function(mutation) {
	    	function _dis(node) {
	        	setTimeout(function() {
	        		try {
	        			disableDoc(node.contentWindow.document);
	        		}
	        		catch(e) { }
	        	}, 300) // wait some time for the doc to settle

	    	}
	    	try {
		        if (!!mutation.addedNodes && mutation.addedNodes.length) {
		        	for (var i=0; i<mutation.addedNodes.length; i++) {
		        		var node = mutation.addedNodes[i];
		        		if (node.nodeName.toLowerCase()=="iframe") {
		        			_dis(node);
			        	}
		        	}
		        } else if (mutation.type=="attributes" && mutation.target.nodeName.toLowerCase()=="iframe") {
	        		_dis(mutation.target);
		        }
	        } catch(e) { } // ignore errors.
	    } );
	}

})