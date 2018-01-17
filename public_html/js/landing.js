webpackJsonp([2],{

/***/ "./resources/assets/js/landing.js":
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {var scrollThreshold = $('.landing').height();
$(window).scroll(function () {
    if ($(this).scrollTop() > scrollThreshold) {
        $("header").removeClass("no-background");
    } else {
        $("header").addClass("no-background");
    }
});
if ($(window).scrollTop() > scrollThreshold) {
    $("header").removeClass("no-background");
}
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__("./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ 1:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/landing.js");


/***/ })

},[1]);