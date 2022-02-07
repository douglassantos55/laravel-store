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
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }


'use strict';

console.log('checkout/checkout.js');

var Address = /*#__PURE__*/function () {
  function Address(selector, cart) {
    _classCallCheck(this, Address);

    this._cart = cart;
    this._useAddressBtn = document.querySelector("".concat(selector, " .js-use-address"));
    this._newAddressBtn = document.querySelector("".concat(selector, " .js-new-address"));
    this._addressForm = document.querySelector("".concat(selector, " .js-address-form"));
    this._existingAddress = document.querySelector("".concat(selector, " .js-existing-address"));

    this._attachListeners();
  }

  _createClass(Address, [{
    key: "_attachListeners",
    value: function _attachListeners() {
      var _this = this;

      this._useAddressBtn.addEventListener('click', this.showAddressList.bind(this));

      this._newAddressBtn.addEventListener('click', this.showAddressForm.bind(this));

      this._existingAddress.querySelectorAll('[name="address_id"]').forEach(function (item) {
        item.addEventListener('change', function (evt) {
          if (_this._cart) {
            _this._cart.update({
              zipcode: evt.target.dataset.zipcode
            });
          }
        });
      });

      this._addressForm.querySelector('[name="address[zipcode]"]').addEventListener('blur', this.fetchAddress.bind(this));
    }
  }, {
    key: "showAddressList",
    value: function showAddressList() {
      this._addressForm.classList.add('hidden');

      this._existingAddress.classList.remove('hidden');

      this._addressForm.querySelectorAll('input').forEach(function (item) {
        return item.value = '';
      });
    }
  }, {
    key: "showAddressForm",
    value: function showAddressForm() {
      this._addressForm.classList.remove('hidden');

      this._existingAddress.classList.add('hidden');

      this._existingAddress.querySelectorAll('[name="address_id"]').forEach(function (item) {
        item.checked = false;
      });
    }
  }, {
    key: "fetchAddress",
    value: function () {
      var _fetchAddress = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(evt) {
        var zipcode, _yield$axios$get, data;

        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                zipcode = evt.target.value.replace(/[^\d]/, '');

                if (!(zipcode.length !== 8)) {
                  _context.next = 3;
                  break;
                }

                return _context.abrupt("return");

              case 3:
                _context.next = 5;
                return _axios__WEBPACK_IMPORTED_MODULE_1__["default"].get("https://viacep.com.br/ws/".concat(zipcode, "/json/"));

              case 5:
                _yield$axios$get = _context.sent;
                data = _yield$axios$get.data;

                if (data.erro) {
                  this.updateAddress();
                } else {
                  this.updateAddress(data);

                  this._addressForm.querySelector('[name="address[number]"]').focus();
                }

                if (this._cart) {
                  this._cart.update({
                    zipcode: zipcode
                  });
                }

              case 9:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function fetchAddress(_x) {
        return _fetchAddress.apply(this, arguments);
      }

      return fetchAddress;
    }()
  }, {
    key: "updateAddress",
    value: function updateAddress(data) {
      this._addressForm.querySelector('[name="address[street]"]').value = data && data.logradouro || '';
      this._addressForm.querySelector('[name="address[complement]"]').value = data && data.complemento || '';
      this._addressForm.querySelector('[name="address[neighborhood]"]').value = data && data.bairro || '';
      this._addressForm.querySelector('[name="address[city]"]').value = data && data.localidade || '';
      this._addressForm.querySelector('[name="address[state]"]').value = data && data.uf || '';
    }
  }]);

  return Address;
}();

var Cart = /*#__PURE__*/function () {
  function Cart(selector) {
    var _this2 = this;

    _classCallCheck(this, Cart);

    this._selector = selector;
    this._el = document.querySelector(this._selector);
    document.addEventListener('change', function (evt) {
      if (evt.target.name === 'shipping_method') {
        _this2.update({
          shipping_method: evt.target.value
        });
      }
    });
  }

  _createClass(Cart, [{
    key: "update",
    value: function () {
      var _update = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2(data) {
        var _this$_el;

        var formData, key, _yield$axios$post, html, parser, doc, newElement;

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
                doc = parser.parseFromString(html, 'text/html'); // replaceChildren maintains reference to this._el

                newElement = doc.querySelector(this._selector);

                (_this$_el = this._el).replaceChildren.apply(_this$_el, _toConsumableArray(newElement.children));

              case 11:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function update(_x2) {
        return _update.apply(this, arguments);
      }

      return update;
    }()
  }]);

  return Cart;
}();

var cart = new Cart('.js-cart-table');
var address = new Address('.js-addresses', cart);

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["js/vendors"], () => (__webpack_exec__("./resources/js/checkout/checkout.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);