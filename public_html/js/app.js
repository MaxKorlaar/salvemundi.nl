webpackJsonp([3],{

/***/ "./resources/assets/js/app.js":
/***/ (function(module, exports, __webpack_require__) {

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__("./resources/assets/js/bootstrap.js");

/***/ }),

/***/ "./resources/assets/js/bootstrap.js":
/***/ (function(module, exports, __webpack_require__) {

/**
 * Door het opgeven van 'autoload' in webpack.mix.js is het niet nodig om in dit bestand jQuery, Popper en Bootstrap te laden en globaal te maken.
 */

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = __webpack_require__("./node_modules/axios/index.js");

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF Missing');
}

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleNotFoundError: Module not found: Error: Can't resolve '../images/images/cover_photo.jpg' in 'C:\\Users\\Niek\\Documents\\salvemundi.nl\\resources\\assets\\sass'\n    at factoryCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\lib\\Compilation.js:282:40)\n    at factory (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\lib\\NormalModuleFactory.js:237:20)\n    at resolver (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\lib\\NormalModuleFactory.js:60:20)\n    at asyncLib.parallel (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\lib\\NormalModuleFactory.js:127:20)\n    at C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\node_modules\\async\\dist\\async.js:3888:9\n    at C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\node_modules\\async\\dist\\async.js:473:16\n    at iteratorCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\node_modules\\async\\dist\\async.js:1062:13)\n    at C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\node_modules\\async\\dist\\async.js:969:16\n    at C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\node_modules\\async\\dist\\async.js:3885:13\n    at resolvers.normal.resolve (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\webpack\\lib\\NormalModuleFactory.js:119:22)\n    at onError (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:65:10)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at runAfter (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:158:4)\n    at innerCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:146:3)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at next (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\tapable\\lib\\Tapable.js:252:11)\n    at C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\UnsafeCachePlugin.js:40:4\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at runAfter (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:158:4)\n    at innerCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:146:3)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at next (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\tapable\\lib\\Tapable.js:252:11)\n    at innerCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:144:11)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at next (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\tapable\\lib\\Tapable.js:249:35)\n    at resolver.doResolve.createInnerCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\DescriptionFilePlugin.js:44:6)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at afterInnerCallback (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\Resolver.js:168:10)\n    at loggingCallbackWrapper (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\enhanced-resolve\\lib\\createInnerCallback.js:31:19)\n    at next (C:\\Users\\Niek\\Documents\\salvemundi.nl\\node_modules\\tapable\\lib\\Tapable.js:252:11)");

/***/ }),

/***/ 0:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/app.js");
module.exports = __webpack_require__("./resources/assets/sass/app.scss");


/***/ })

},[0]);