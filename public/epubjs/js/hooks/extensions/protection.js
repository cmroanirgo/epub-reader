EPUBJS.Hooks.register("beforeChapterDisplay").protection = function(callback, renderer){

    EPUBJS.core.addScript(EPUBJS.filePath + "jquery.min.js", null, renderer.doc.head);
    EPUBJS.core.addScript(EPUBJS.filePath + "protection.js", null, renderer.doc.head);
    
    if(callback) callback();
}


