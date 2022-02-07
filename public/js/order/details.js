"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/order/details"],{

/***/ "./resources/js/echo.js":
/*!******************************!*\
  !*** ./resources/js/echo.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var laravel_echo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! laravel-echo */ "./node_modules/laravel-echo/dist/echo.js");
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

window.Pusher = __webpack_require__(/*! pusher-js */ "./node_modules/pusher-js/dist/web/pusher.js");
var instance = new laravel_echo__WEBPACK_IMPORTED_MODULE_0__["default"]({
  broadcaster: 'pusher',
  key: "myapp",
  cluster: "mt1",
  forceTLS: false,
  wsHost: window.location.hostname,
  wsPort: 6001,
  disableStats: true
});
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (instance);

/***/ }),

/***/ "./resources/js/order/details.js":
/*!***************************************!*\
  !*** ./resources/js/order/details.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _echo__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../echo */ "./resources/js/echo.js");

'use strict';

console.log('order/details.js');
_echo__WEBPACK_IMPORTED_MODULE_0__["default"]["private"]('App.Models.User.1').notification(function (evt) {
  if (evt.type === 'App\\Notifications\\OrderStatusChanged') {
    if (confirm('Order status change, refresh page?')) {
      window.location.reload();
    }
  }
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["js/vendors"], () => (__webpack_exec__("./resources/js/order/details.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);