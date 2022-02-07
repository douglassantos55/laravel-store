"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["/js/checkout/checkout"],{

/***/ "./resources/js/axios.js":
/*!*******************************!*\
  !*** ./resources/js/axios.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
var axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (axios);

/***/ }),

/***/ "./resources/js/checkout/checkout.js":
/*!*******************************************!*\
  !*** ./resources/js/checkout/checkout.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../axios */ "./resources/js/axios.js");


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


'use strict';

console.log('checkout/checkout.js');
var newAddress = document.querySelector('.js-new-address');

if (newAddress) {
  newAddress.addEventListener('click', function (evt) {
    document.querySelector('.js-address').classList.remove('hidden');
    document.querySelector('.js-existing-address').classList.add('hidden');
    document.querySelectorAll('.js-address-item').forEach(function (item) {
      item.querySelector('input').checked = false;
    });
  });
}

var useAddress = document.querySelector('.js-use-address');

if (useAddress) {
  useAddress.addEventListener('click', function (evt) {
    document.querySelector('.js-address').classList.add('hidden');
    document.querySelector('.js-existing-address').classList.remove('hidden');
  });
}

var zipcode = document.querySelector('[name="address[zipcode]"]');

if (zipcode) {
  zipcode.addEventListener('blur', /*#__PURE__*/function () {
    var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(evt) {
      var _yield$axios$get, data;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              _context.next = 2;
              return _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("https://viacep.com.br/ws/".concat(evt.target.value, "/json/"));

            case 2:
              _yield$axios$get = _context.sent;
              data = _yield$axios$get.data;

              if (data.erro) {
                updateAddress();
              } else {
                updateAddress(data);
                document.querySelector('[name="address[number]"]').focus();
              }

              updateCart({
                zipcode: evt.target.value
              });

            case 6:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }));

    return function (_x) {
      return _ref.apply(this, arguments);
    };
  }());
  zipcode.dispatchEvent(new FocusEvent('blur'));
}

document.addEventListener('change', function (evt) {
  if (evt.target.name === 'shipping_method') {
    updateCart({
      shipping_method: evt.target.value
    });
  }

  if (evt.target.name === 'address_id') {
    updateCart({
      zipcode: evt.target.dataset.zipcode
    });
  }
});

function updateAddress(data) {
  document.querySelector('[name="address[street]"]').value = data && data.logradouro || '';
  document.querySelector('[name="address[complement]"]').value = data && data.complemento || '';
  document.querySelector('[name="address[neighborhood]"]').value = data && data.bairro || '';
  document.querySelector('[name="address[city]"]').value = data && data.localidade || '';
  document.querySelector('[name="address[state]"]').value = data && data.uf || '';
}

function updateCart(_x2) {
  return _updateCart.apply(this, arguments);
}

function _updateCart() {
  _updateCart = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(data) {
    var formData, key, _yield$axios$post, html, parser, doc;

    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            formData = new FormData();
            formData.append('_method', 'put');

            for (key in data) {
              formData.append(key, data[key]);
            }

            _context2.next = 5;
            return _axios__WEBPACK_IMPORTED_MODULE_1__["default"].post('/cart', formData);

          case 5:
            _yield$axios$post = _context2.sent;
            html = _yield$axios$post.data;
            parser = new DOMParser();
            doc = parser.parseFromString(html, 'text/html');
            document.querySelector('.js-cart-table').replaceWith(doc.querySelector('.js-cart-table'));

          case 10:
          case "end":
            return _context2.stop();
        }
      }
    }, _callee2);
  }));
  return _updateCart.apply(this, arguments);
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["js/vendors"], () => (__webpack_exec__("./resources/js/checkout/checkout.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);