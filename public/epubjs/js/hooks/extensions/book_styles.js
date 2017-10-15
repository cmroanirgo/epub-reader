EPUBJS.Hooks.register("beforeChapterDisplay").bookStyles = function(callback, renderer){

    var s = document.createElement("style"); 
    s.innerHTML ="* { box-sizing: border-box };\n"+
    "html, body { margin:0; padding:0; }\n";
    renderer.render.document.head.appendChild(s);
    
    if(callback) callback();
}


