webpackJsonp([1],{"+66z":function(t,e){var n=Object.prototype.toString;t.exports=function(t){return n.call(t)}},"0ghZ":function(t,e,n){var r=n("PfJA"),o=n("iYj9"),u=n("KGqH");t.exports=function(t){return o(t)?u(t):r(t)}},2:function(t,e,n){t.exports=n("E9lt")},"3IRH":function(t,e){t.exports=function(t){return t.webpackPolyfill||(t.deprecate=function(){},t.paths=[],t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),t.webpackPolyfill=1),t}},"5Zxu":function(t,e,n){var r=n("sBat");t.exports=function(t){var e=r(t),n=e%1;return e==e?n?e-n:e:0}},"6MiT":function(t,e,n){var r=n("aCM0"),o=n("UnEC"),u="[object Symbol]";t.exports=function(t){return"symbol"==typeof t||o(t)&&r(t)==u}},Dc0G:function(t,e,n){(function(t){var r=n("blYT"),o="object"==typeof e&&e&&!e.nodeType&&e,u=o&&"object"==typeof t&&t&&!t.nodeType&&t,i=u&&u.exports===o&&r.process,f=function(){try{var t=u&&u.require&&u.require("util").types;return t||i&&i.binding&&i.binding("util")}catch(t){}}();t.exports=f}).call(e,n("3IRH")(t))},E9lt:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=n("mtWM"),o=(n.n(r),n("GRSR"));n.n(o);n("WRGp"),window.Vue=n("I3G/"),new Vue({el:"#store-app",data:{loaded:!1,item:{description:""},stock:[],selectedStock:{description:null}},methods:{formatPrice:function(t){return parseFloat(t).toFixed(2).replace(".",",")}},computed:{description:function(){return null!==this.selectedStock.description?this.selectedStock.description.replace(/(\r\n|\n\r|\r|\n)/g,"<br>"):this.item.description.replace(/(\r\n|\n\r|\r|\n)/g,"<br>")}},mounted:function(){this.item=window.SalveMundi.store.item,this.stock=window.SalveMundi.store.stock,this.selectedStock=this.stock[0],this.loaded=!0}})},GOFJ:function(t,e,n){var r=n("OdGI"),o=n("iYj9"),u=n("Z8WZ");t.exports=function(t){return o(t)?u(t):r(t)}},GRSR:function(t,e,n){var r=n("o2mx"),o=n("Wh6c"),u=n("iYj9"),i=n("yCNF"),f=n("HC1p"),c=n("GOFJ"),s=n("0ghZ"),a=n("5Zxu"),d=n("ZT2e"),l=30,p="...",v=/\w*$/;t.exports=function(t,e){var n=l,x=p;if(i(e)){var b="separator"in e?e.separator:b;n="length"in e?a(e.length):n,x="omission"in e?r(e.omission):x}var y=(t=d(t)).length;if(u(t)){var g=s(t);y=g.length}if(n>=y)return t;var h=n-c(x);if(h<1)return x;var j=g?o(g,0,h).join(""):t.slice(0,h);if(void 0===b)return j+x;if(g&&(h+=j.length-h),f(b)){if(t.slice(h).search(b)){var m,R=j;for(b.global||(b=RegExp(b.source,d(v.exec(b))+"g")),b.lastIndex=0;m=b.exec(R);)var O=m.index;j=j.slice(0,void 0===O?h:O)}}else if(t.indexOf(r(b),h)!=h){var S=j.lastIndexOf(b);S>-1&&(j=j.slice(0,S))}return j+x}},HC1p:function(t,e,n){var r=n("y9sD"),o=n("S7p9"),u=n("Dc0G"),i=u&&u.isRegExp,f=i?o(i):r;t.exports=f},Hxdr:function(t,e){t.exports=function(t,e){for(var n=-1,r=null==t?0:t.length,o=Array(r);++n<r;)o[n]=e(t[n],n,t);return o}},KGqH:function(t,e){var n="[\\ud800-\\udfff]",r="[\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff]",o="\\ud83c[\\udffb-\\udfff]",u="[^\\ud800-\\udfff]",i="(?:\\ud83c[\\udde6-\\uddff]){2}",f="[\\ud800-\\udbff][\\udc00-\\udfff]",c="(?:"+r+"|"+o+")"+"?",s="[\\ufe0e\\ufe0f]?"+c+("(?:\\u200d(?:"+[u,i,f].join("|")+")[\\ufe0e\\ufe0f]?"+c+")*"),a="(?:"+[u+r+"?",r,i,f,n].join("|")+")",d=RegExp(o+"(?="+o+")|"+a+s,"g");t.exports=function(t){return t.match(d)||[]}},M1c9:function(t,e){t.exports=function(t,e,n){var r=-1,o=t.length;e<0&&(e=-e>o?0:o+e),(n=n>o?o:n)<0&&(n+=o),o=e>n?0:n-e>>>0,e>>>=0;for(var u=Array(o);++r<o;)u[r]=t[r+e];return u}},NGEn:function(t,e){var n=Array.isArray;t.exports=n},NkRn:function(t,e,n){var r=n("TQ3y").Symbol;t.exports=r},OdGI:function(t,e,n){var r=n("eG8/")("length");t.exports=r},PfJA:function(t,e){t.exports=function(t){return t.split("")}},S7p9:function(t,e){t.exports=function(t){return function(e){return t(e)}}},TQ3y:function(t,e,n){var r=n("blYT"),o="object"==typeof self&&self&&self.Object===Object&&self,u=r||o||Function("return this")();t.exports=u},UnEC:function(t,e){t.exports=function(t){return null!=t&&"object"==typeof t}},WRGp:function(t,e,n){window.axios=n("mtWM"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";var r=document.head.querySelector('meta[name="csrf-token"]');r?window.axios.defaults.headers.common["X-CSRF-TOKEN"]=r.content:console.error("CSRF Missing")},Wh6c:function(t,e,n){var r=n("M1c9");t.exports=function(t,e,n){var o=t.length;return n=void 0===n?o:n,!e&&n>=o?t:r(t,e,n)}},Z8WZ:function(t,e){var n="[\\ud800-\\udfff]",r="[\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff]",o="\\ud83c[\\udffb-\\udfff]",u="[^\\ud800-\\udfff]",i="(?:\\ud83c[\\udde6-\\uddff]){2}",f="[\\ud800-\\udbff][\\udc00-\\udfff]",c="(?:"+r+"|"+o+")"+"?",s="[\\ufe0e\\ufe0f]?"+c+("(?:\\u200d(?:"+[u,i,f].join("|")+")[\\ufe0e\\ufe0f]?"+c+")*"),a="(?:"+[u+r+"?",r,i,f,n].join("|")+")",d=RegExp(o+"(?="+o+")|"+a+s,"g");t.exports=function(t){for(var e=d.lastIndex=0;d.test(t);)++e;return e}},ZT2e:function(t,e,n){var r=n("o2mx");t.exports=function(t){return null==t?"":r(t)}},aCM0:function(t,e,n){var r=n("NkRn"),o=n("uLhX"),u=n("+66z"),i="[object Null]",f="[object Undefined]",c=r?r.toStringTag:void 0;t.exports=function(t){return null==t?void 0===t?f:i:c&&c in Object(t)?o(t):u(t)}},blYT:function(t,e,n){(function(e){var n="object"==typeof e&&e&&e.Object===Object&&e;t.exports=n}).call(e,n("DuR2"))},"eG8/":function(t,e){t.exports=function(t){return function(e){return null==e?void 0:e[t]}}},iYj9:function(t,e){var n=RegExp("[\\u200d\\ud800-\\udfff\\u0300-\\u036f\\ufe20-\\ufe2f\\u20d0-\\u20ff\\ufe0e\\ufe0f]");t.exports=function(t){return n.test(t)}},kxzG:function(t,e,n){var r=n("yCNF"),o=n("6MiT"),u=NaN,i=/^\s+|\s+$/g,f=/^[-+]0x[0-9a-f]+$/i,c=/^0b[01]+$/i,s=/^0o[0-7]+$/i,a=parseInt;t.exports=function(t){if("number"==typeof t)return t;if(o(t))return u;if(r(t)){var e="function"==typeof t.valueOf?t.valueOf():t;t=r(e)?e+"":e}if("string"!=typeof t)return 0===t?t:+t;t=t.replace(i,"");var n=c.test(t);return n||s.test(t)?a(t.slice(2),n?2:8):f.test(t)?u:+t}},o2mx:function(t,e,n){var r=n("NkRn"),o=n("Hxdr"),u=n("NGEn"),i=n("6MiT"),f=1/0,c=r?r.prototype:void 0,s=c?c.toString:void 0;t.exports=function t(e){if("string"==typeof e)return e;if(u(e))return o(e,t)+"";if(i(e))return s?s.call(e):"";var n=e+"";return"0"==n&&1/e==-f?"-0":n}},sBat:function(t,e,n){var r=n("kxzG"),o=1/0,u=1.7976931348623157e308;t.exports=function(t){return t?(t=r(t))===o||t===-o?(t<0?-1:1)*u:t==t?t:0:0===t?t:0}},uLhX:function(t,e,n){var r=n("NkRn"),o=Object.prototype,u=o.hasOwnProperty,i=o.toString,f=r?r.toStringTag:void 0;t.exports=function(t){var e=u.call(t,f),n=t[f];try{t[f]=void 0;var r=!0}catch(t){}var o=i.call(t);return r&&(e?t[f]=n:delete t[f]),o}},y9sD:function(t,e,n){var r=n("aCM0"),o=n("UnEC"),u="[object RegExp]";t.exports=function(t){return o(t)&&r(t)==u}},yCNF:function(t,e){t.exports=function(t){var e=typeof t;return null!=t&&("object"==e||"function"==e)}}},[2]);