jQuery(document).ready(function(){
        const eventLLS = new Event('lazyLoadScripts');
    var app = {
        init: function() {
            window.addEventListener("scroll", function() {
                if (window.__he == undefined) {
                    app.load();
                }
            });
            window.addEventListener("mousemove", function() {
                if (window.__he == undefined) {
                    app.load();
                }
            });
        },
        load: function() {
            window["__he"] = true;
            setTimeout(function (){
                window.dispatchEvent(eventLLS);
                console.log('Lazyload Scripts triggered')
            }, 500);
        }
    };

    window.addEventListener('lazyLoadScripts', function (e) {
        if(scripts !== undefined && scripts.length > 0) {
            console.log(scripts);
            iterateScripts(scripts, 0);
        }
        if(styles !== undefined && styles.length > 0) {
            console.log(styles);
            jQuery(styles).each(function (k, e) {
                jQuery('body').append('<link rel="stylesheet" id="' + k + '-css" href="' + e + '" type="text/css" media="all">');
            });
        }
    }, false);

    app.init();

    function iterateScripts(sc, i){
        var keys = Object.keys(sc);
        var e = sc[keys[i]];
        if(e !== undefined) {
            var jsScript = document.createElement('script');
            jsScript.src = e;
            document.body.appendChild(jsScript);
            i++;
            jsScript.addEventListener('load', () => {
                iterateScripts(sc, i);
            });
        }
    }
});