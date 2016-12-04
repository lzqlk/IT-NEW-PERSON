/**
 * Created by lg on 2016/3/31.
 */
(function () {
    if (window.performance && window.performance.getEntriesByType && window.addEventListener && navigator.userAgent) {
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
            (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
                (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
                    (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
                        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
                            (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
        windows = (ua.indexOf("windows", 0) != -1) ? 1 : 0;
        mac = (ua.indexOf("mac", 0) != -1) ? 1 : 0;
        linux = (ua.indexOf("linux", 0) != -1) ? 1 : 0;
        unix = (ua.indexOf("x11", 0) != -1) ? 1 : 0;
        var os = '';
        var bs = '';
        if (windows) os = "MS Windows";
        else if (mac) os = "Apple mac";
        else if (linux) os = "Linux";
        else if (unix) os = "Unix";
        else os = 'other';
        if (Sys.ie) bs = ('IE: ' + Sys.ie);
        if (Sys.firefox) bs = ('Firefox: ' + Sys.firefox);
        if (Sys.chrome) bs = ('Chrome: ' + Sys.chrome);
        if (Sys.opera) bs = ('Opera: ' + Sys.opera);
        if (Sys.safari) bs = ('Safari: ' + Sys.safari);
        var errors = 0;
        window.onerror = function (errorMessage, scriptURI, lineNumber, columnNumber, errorObj) {
            var eob;
            errors=errors+1;
            try {eob = errorObj.stack.replace(/\s+/g, ' ')}
            catch (err) {eob = errorObj}
            var send = '?u=' + location.pathname + '&em=' + errorMessage + '&su=' + scriptURI + '&ln=' + lineNumber + '&cm=' + columnNumber + '&eo=' + eob + '&os=' + os + '&bs=' + bs;
            if (errors<50){loadXMLDoc('/upload/ltm/oss.html' + send + "&t=" + (+new Date()));}
        };
        var addError = {};
        window.addEventListener('error', function (event) {
            if (event.srcElement) {
                lname = event.srcElement.localName;
                if (lname == 'script' || lname == 'img') {
                    addError[event.srcElement.src] = event.timeStamp;
                }
                else if (lname == 'link') {
                    addError[event.srcElement.href] = event.timeStamp;
                }
            }
        }, true);

        var Ping = function () {
        };
        Ping.prototype.ping = function (source, callback) {
            this.img = new Image();
            var start = new Date();
            this.img.onload = this.img.onerror = pingCheck;
            function pingCheck() {
                var pong = new Date() - start;
                if (typeof callback === "function") {
                    callback(pong);
                }
            }

            this.img.src = source + "?" + (+new Date());
        };

        window.addEventListener("load", function (event) {
            var dom_timing = window.performance.timing;
            if (dom_timing.domainLookupEnd > 0 && dom_timing.domainLookupStart > 0
                && dom_timing.responseStart > 0 && dom_timing.connectStart > 0
                && dom_timing.responseEnd > 0 && dom_timing.domInteractive > 0
                && dom_timing.domLoading > 0 && dom_timing.loadEventStart > 0
                && dom_timing.domComplete > 0 && dom_timing.fetchStart > 0
            ) {
                var dns_t = dom_timing.domainLookupEnd - dom_timing.domainLookupStart;
                var queue_t = dom_timing.responseStart - dom_timing.connectStart;
                var net_t = dom_timing.responseEnd - dom_timing.connectStart;
                var dom_t = dom_timing.domInteractive - dom_timing.domLoading;
                var load_t = dom_timing.loadEventStart - dom_timing.domInteractive;
                var pageLoadTime = dom_timing.domComplete - dom_timing.fetchStart;
                net_t = (net_t>0) ? net_t : '0';
                dom_t = (dom_t>0) ? dom_t : '0';
                queue_t = (queue_t>0) ? queue_t : '0';
                if (pageLoadTime > 20000) {
                    var entries = performance.getEntriesByType("resource");
                    var r;
                    var e = [];
                    var data = '';
                    var val = [];
                    var addError_k = Object.keys(addError);
                    var is_l = 0;
                    for (var i = 0, l = entries.length; i < l; i++) {
                        r = entries[i];
                        var name_r = r.name;
                        var initiatorType_r = r.initiatorType;
                        var duration_r = r.duration;
                        duration_r = (duration_r >= 0) ? duration_r : 0;
                        if (iscon(addError_k, name_r)) {
                            delete addError[name_r];
                            is_l = 1
                        }
                        else {
                            is_l = 0
                        }
                        if (duration_r > 1000 && duration_r < 100000000) {
                            e.push({'n': urlsplit(name_r), 'v': duration_r.toFixed(2), 'err': is_l});
                        }
                    }
                    addError_k = Object.keys(addError);
                    var addError_v = 0;
                    for (var ei = 0, el = addError_k.length; ei < el; ei++) {
                        addError_v = addError[addError_k[ei]] - net_t;
                        if (addError_v > 1000 && addError_v < 100000000) {
                            e.push({'n': urlsplit(addError_k[ei]), 'v': addError_v.toFixed(2), 'err': 1});
                        }
                    }
                    e.sort(by("v"));
                    var e_l = e.length;
                    if (e_l > 10) {
                        e = e.slice(e_l - 10, e_l)
                    }
                    if (e.length > 0) {
                        data = '?u=' + location.pathname + '&d=' + encodeURIComponent(JSON.stringify(e)) + '&os=' + os + '&bs=' + bs + '&l=' + entries.length;
                        loadXMLDoc('/upload/ltm/pageload.html' + data + "&t=" + (+new Date()));
                    }
                }
                var p = new Ping();
                p.ping("/upload/edm/image/oss.gif", function (data) {
                    var send = '?u=' + location.pathname + '&q=' + queue_t + '&n=' + net_t + '&d=' + dom_t + '&l=' + load_t + '&dns=' + dns_t + '&p=' + pageLoadTime + '&pi=' + data;
                    loadXMLDoc('/upload/ltm/oss.html' + send + "&t=" + (+new Date()));
                });
            }
        });


        function loadXMLDoc(url, id, data) {
            var loadMethod = (id == 1) ? 'POST' : 'GET';
            if (data == 'undefined') {
                data = null
            }
            var xmlhttp = null;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            }
            if (xmlhttp != null) {
                xmlhttp.onreadystatechange = state_Change;
                xmlhttp.open(loadMethod, url, true);
                xmlhttp.setRequestHeader("Content-type", "application/json;charset=utf-8");
                xmlhttp.send(data);
            }
            function state_Change() {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 200) {
                        var b = xmlhttp.responseText;
                    }
                    else {
                    }
                }
            }
        }


        function urlsplit(url) {
            return url.split('?')[0]
        }

        var by = function (name) {
            return function (o, p) {
                var a, b;
                if (typeof o === "object" && typeof p === "object" && o && p) {
                    a = o[name];
                    b = p[name];
                    if (a === b) {
                        return 0;
                    }
                    if (typeof a === typeof b) {
                        return parseInt(a) < parseInt(b) ? -1 : 1;
                    }
                    return typeof a < typeof b ? -1 : 1;
                }
                else {
                    return 0;
                }
            }
        };
        var iscon = function (s, a) {
            for (var isc = 0, l = s.length; isc < l; isc++) {
                if (s[isc] == a) return true;
            }
            return false;
        };
    }
})();