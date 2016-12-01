!function(e,t,n){function r(e,t){return typeof e===t}function o(){var e,t,n,o,i,a,s;for(var l in h)if(h.hasOwnProperty(l)){if(e=[],t=h[l],t.name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(n=0;n<t.options.aliases.length;n++)e.push(t.options.aliases[n].toLowerCase());for(o=r(t.fn,"function")?t.fn():t.fn,i=0;i<e.length;i++)a=e[i],s=a.split("."),1===s.length?g[s[0]]=o:(!g[s[0]]||g[s[0]]instanceof Boolean||(g[s[0]]=new Boolean(g[s[0]])),g[s[0]][s[1]]=o),b.push((o?"":"no-")+s.join("-"))}}function i(e){var t=E.className,n=g._config.classPrefix||"";if(S&&(t=t.baseVal),g._config.enableJSClass){var r=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");t=t.replace(r,"$1"+n+"js$2")}g._config.enableClasses&&(t+=" "+n+e.join(" "+n),S?E.className.baseVal=t:E.className=t)}function a(e,t){if("object"==typeof e)for(var n in e)y(e,n)&&a(n,e[n]);else{e=e.toLowerCase();var r=e.split("."),o=g[r[0]];if(2==r.length&&(o=o[r[1]]),"undefined"!=typeof o)return g;t="function"==typeof t?t():t,1==r.length?g[r[0]]=t:(!g[r[0]]||g[r[0]]instanceof Boolean||(g[r[0]]=new Boolean(g[r[0]])),g[r[0]][r[1]]=t),i([(t&&0!=t?"":"no-")+r.join("-")]),g._trigger(e,t)}return g}function s(e,t){return!!~(""+e).indexOf(t)}function l(){return"function"!=typeof t.createElement?t.createElement(arguments[0]):S?t.createElementNS.call(t,"http://www.w3.org/2000/svg",arguments[0]):t.createElement.apply(t,arguments)}function u(){var e=t.body;return e||(e=l(S?"svg":"body"),e.fake=!0),e}function c(e,n,r,o){var i,a,s,c,d="modernizr",f=l("div"),p=u();if(parseInt(r,10))for(;r--;)s=l("div"),s.id=o?o[r]:d+(r+1),f.appendChild(s);return i=l("style"),i.type="text/css",i.id="s"+d,(p.fake?p:f).appendChild(i),p.appendChild(f),i.styleSheet?i.styleSheet.cssText=e:i.appendChild(t.createTextNode(e)),f.id=d,p.fake&&(p.style.background="",p.style.overflow="hidden",c=E.style.overflow,E.style.overflow="hidden",E.appendChild(p)),a=n(f,e),p.fake?(p.parentNode.removeChild(p),E.style.overflow=c,E.offsetHeight):f.parentNode.removeChild(f),!!a}function d(e){return e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-")}function f(t,r){var o=t.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(d(t[o]),r))return!0;return!1}if("CSSSupportsRule"in e){for(var i=[];o--;)i.push("("+d(t[o])+":"+r+")");return i=i.join(" or "),c("@supports ("+i+") { #modernizr { position: absolute; } }",function(e){return"absolute"==getComputedStyle(e,null).position})}return n}function p(e){return e.replace(/([a-z])-([a-z])/g,function(e,t,n){return t+n.toUpperCase()}).replace(/^-/,"")}function m(e,t,o,i){function a(){c&&(delete w.style,delete w.modElem)}if(i=!r(i,"undefined")&&i,!r(o,"undefined")){var u=f(e,o);if(!r(u,"undefined"))return u}for(var c,d,m,h,v,g=["modernizr","tspan"];!w.style;)c=!0,w.modElem=l(g.shift()),w.style=w.modElem.style;for(m=e.length,d=0;d<m;d++)if(h=e[d],v=w.style[h],s(h,"-")&&(h=p(h)),w.style[h]!==n){if(i||r(o,"undefined"))return a(),"pfx"!=t||h;try{w.style[h]=o}catch(y){}if(w.style[h]!=v)return a(),"pfx"!=t||h}return a(),!1}var h=[],v={_version:"3.3.1",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var n=this;setTimeout(function(){t(n[e])},0)},addTest:function(e,t,n){h.push({name:e,fn:t,options:n})},addAsyncTest:function(e){h.push({name:null,fn:e})}},g=function(){};g.prototype=v,g=new g;var y,b=[];!function(){var e={}.hasOwnProperty;y=r(e,"undefined")||r(e.call,"undefined")?function(e,t){return t in e&&r(e.constructor.prototype[t],"undefined")}:function(t,n){return e.call(t,n)}}();var E=t.documentElement,S="svg"===E.nodeName.toLowerCase();v._l={},v.on=function(e,t){this._l[e]||(this._l[e]=[]),this._l[e].push(t),g.hasOwnProperty(e)&&setTimeout(function(){g._trigger(e,g[e])},0)},v._trigger=function(e,t){if(this._l[e]){var n=this._l[e];setTimeout(function(){var e,r;for(e=0;e<n.length;e++)(r=n[e])(t)},0),delete this._l[e]}},g._q.push(function(){v.addTest=a});S||!function(e,t){function n(e,t){var n=e.createElement("p"),r=e.getElementsByTagName("head")[0]||e.documentElement;return n.innerHTML="x<style>"+t+"</style>",r.insertBefore(n.lastChild,r.firstChild)}function r(){var e=C.elements;return"string"==typeof e?e.split(" "):e}function o(e,t){var n=C.elements;"string"!=typeof n&&(n=n.join(" ")),"string"!=typeof e&&(e=e.join(" ")),C.elements=n+" "+e,u(t)}function i(e){var t=w[e[S]];return t||(t={},T++,e[S]=T,w[T]=t),t}function a(e,n,r){if(n||(n=t),v)return n.createElement(e);r||(r=i(n));var o;return o=r.cache[e]?r.cache[e].cloneNode():E.test(e)?(r.cache[e]=r.createElem(e)).cloneNode():r.createElem(e),!o.canHaveChildren||b.test(e)||o.tagUrn?o:r.frag.appendChild(o)}function s(e,n){if(e||(e=t),v)return e.createDocumentFragment();n=n||i(e);for(var o=n.frag.cloneNode(),a=0,s=r(),l=s.length;a<l;a++)o.createElement(s[a]);return o}function l(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(n){return C.shivMethods?a(n,e,t):t.createElem(n)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+r().join().replace(/[\w\-:]+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(C,t.frag)}function u(e){e||(e=t);var r=i(e);return!C.shivCSS||h||r.hasCSS||(r.hasCSS=!!n(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),v||l(e,r),e}function c(e){for(var t,n=e.getElementsByTagName("*"),o=n.length,i=RegExp("^(?:"+r().join("|")+")$","i"),a=[];o--;)t=n[o],i.test(t.nodeName)&&a.push(t.applyElement(d(t)));return a}function d(e){for(var t,n=e.attributes,r=n.length,o=e.ownerDocument.createElement(N+":"+e.nodeName);r--;)t=n[r],t.specified&&o.setAttribute(t.nodeName,t.nodeValue);return o.style.cssText=e.style.cssText,o}function f(e){for(var t,n=e.split("{"),o=n.length,i=RegExp("(^|[\\s,>+~])("+r().join("|")+")(?=[[\\s,>+~#.:]|$)","gi"),a="$1"+N+"\\:$2";o--;)t=n[o]=n[o].split("}"),t[t.length-1]=t[t.length-1].replace(i,a),n[o]=t.join("}");return n.join("{")}function p(e){for(var t=e.length;t--;)e[t].removeNode()}function m(e){function t(){clearTimeout(a._removeSheetTimer),r&&r.removeNode(!0),r=null}var r,o,a=i(e),s=e.namespaces,l=e.parentWindow;return!_||e.printShived?e:("undefined"==typeof s[N]&&s.add(N),l.attachEvent("onbeforeprint",function(){t();for(var i,a,s,l=e.styleSheets,u=[],d=l.length,p=Array(d);d--;)p[d]=l[d];for(;s=p.pop();)if(!s.disabled&&x.test(s.media)){try{i=s.imports,a=i.length}catch(m){a=0}for(d=0;d<a;d++)p.push(i[d]);try{u.push(s.cssText)}catch(m){}}u=f(u.reverse().join("")),o=c(e),r=n(e,u)}),l.attachEvent("onafterprint",function(){p(o),clearTimeout(a._removeSheetTimer),a._removeSheetTimer=setTimeout(t,500)}),e.printShived=!0,e)}var h,v,g="3.7.3",y=e.html5||{},b=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,E=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,S="_html5shiv",T=0,w={};!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",h="hidden"in e,v=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(n){h=!0,v=!0}}();var C={elements:y.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:g,shivCSS:y.shivCSS!==!1,supportsUnknownElements:v,shivMethods:y.shivMethods!==!1,type:"default",shivDocument:u,createElement:a,createDocumentFragment:s,addElements:o};e.html5=C,u(t);var x=/^$|\b(?:all|print)\b/,N="html5shiv",_=!v&&function(){var n=t.documentElement;return!("undefined"==typeof t.namespaces||"undefined"==typeof t.parentWindow||"undefined"==typeof n.applyElement||"undefined"==typeof n.removeNode||"undefined"==typeof e.attachEvent)}();C.type+=" print",C.shivPrint=m,m(t),"object"==typeof module&&module.exports&&(module.exports=C)}("undefined"!=typeof e?e:this,t);var T={elem:l("modernizr")};g._q.push(function(){delete T.elem});var w={style:T.elem.style};g._q.unshift(function(){delete w.style});v.testProp=function(e,t,r){return m([e],n,t,r)};g.addTest("svg",!!t.createElementNS&&!!t.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect),g.addTest("hidden","hidden"in l("a")),g.addTest("canvas",function(){var e=l("canvas");return!(!e.getContext||!e.getContext("2d"))}),g.addTest("cors","XMLHttpRequest"in e&&"withCredentials"in new XMLHttpRequest);var C=l("input"),x="autocomplete autofocus list placeholder max min multiple pattern required step".split(" "),N={};g.input=function(t){for(var n=0,r=t.length;n<r;n++)N[t[n]]=!!(t[n]in C);return N.list&&(N.list=!(!l("datalist")||!e.HTMLDataListElement)),N}(x);var _=function(){function e(e,t){var o;return!!e&&(t&&"string"!=typeof t||(t=l(t||"div")),e="on"+e,o=e in t,!o&&r&&(t.setAttribute||(t=l("div")),t.setAttribute(e,""),o="function"==typeof t[e],t[e]!==n&&(t[e]=n),t.removeAttribute(e)),o)}var r=!("onblur"in t.documentElement);return e}();v.hasEvent=_,g.addTest("inputsearchevent",_("search")),g.addTest("json","JSON"in e&&"parse"in JSON&&"stringify"in JSON),g.addTest("webanimations","animate"in l("div"));var j=v.testStyles=c;g.addTest("checked",function(){return j("#modernizr {position:absolute} #modernizr input {margin-left:10px} #modernizr :checked {margin-left:20px;display:block}",function(e){var t=l("input");return t.setAttribute("type","checkbox"),t.setAttribute("checked","checked"),e.appendChild(t),20===t.offsetLeft})});var k=v._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):[];v._prefixes=k,g.addTest("opacity",function(){var e=l("a").style;return e.cssText=k.join("opacity:.55;"),/^0.55$/.test(e.opacity)}),g.addTest("target",function(){var t=e.document;if(!("querySelectorAll"in t))return!1;try{return t.querySelectorAll(":target"),!0}catch(n){return!1}}),g.addTest("dataset",function(){var e=l("div");return e.setAttribute("data-a-b","c"),!(!e.dataset||"c"!==e.dataset.aB)}),g.addTest("template","content"in l("template")),g.addTest("contains",r(String.prototype.contains,"function")),g.addTest("fileinput",function(){if(navigator.userAgent.match(/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle\/(1.0|2.0|2.5|3.0))/))return!1;var e=l("input");return e.type="file",!e.disabled}),g.addTest("placeholder","placeholder"in l("input")&&"placeholder"in l("textarea")),o(),delete v.addTest,delete v.addAsyncTest;for(var A=0;A<g._q.length;A++)g._q[A]();e.Modernizr=g}(window,document);