import axios from '../axios';

'use strict';

console.log('checkout/checkout.js');

class Address {
    constructor(selector, cart) {
        this._useAddressBtn = document.querySelector(`${selector} .js-use-address`);
        this._newAddressBtn = document.querySelector(`${selector} .js-new-address`);

        this._addressForm = document.querySelector(`${selector} .js-address-form`);
        this._existingAddress = document.querySelector(`${selector} .js-existing-address`);

        this._attachListeners();
    }

    _attachListeners() {
        this._useAddressBtn.addEventListener('click', this.showAddressList.bind(this));
        this._newAddressBtn.addEventListener('click', this.showAddressForm.bind(this));

        this._existingAddress.querySelectorAll('[name="address_id"]').forEach((item) => {
            item.addEventListener('change', (evt) => {
                document.dispatchEvent(new CustomEvent('address.changed', {
                    detail: {
                        zipcode: evt.target.dataset.zipcode
                    }
                }));
            });
        });

        this._addressForm.querySelector('[name="address[zipcode]"]')
            .addEventListener('blur', this.fetchAddress.bind(this));
    }

    showAddressList() {
        this._addressForm.classList.add('hidden');
        this._existingAddress.classList.remove('hidden');

        this._addressForm.querySelectorAll('input').forEach(item => item.value = '');
    }

    showAddressForm() {
        this._addressForm.classList.remove('hidden');
        this._existingAddress.classList.add('hidden');

        this._existingAddress.querySelectorAll('[name="address_id"]').forEach(item => {
            item.checked = false;
        });
    }

    async fetchAddress(evt) {
        const zipcode = evt.target.value.replace(/[^\d]/, '');

        if (zipcode.length !== 8) {
            return;
        }

        const { data } = await axios.get(`https://viacep.com.br/ws/${zipcode}/json/`)

        if (data.erro) {
            this.updateAddress();
        } else {
            this.updateAddress(data);
            this._addressForm.querySelector('[name="address[number]"]').focus();
        }

        document.dispatchEvent(new CustomEvent('address.changed', { detail: { zipcode } }));
    }

    updateAddress(data) {
        this._addressForm.querySelector('[name="address[street]"]').value = data && data.logradouro || '';
        this._addressForm.querySelector('[name="address[complement]"]').value = data && data.complemento || '';
        this._addressForm.querySelector('[name="address[neighborhood]"]').value = data && data.bairro || '';
        this._addressForm.querySelector('[name="address[city]"]').value = data && data.localidade || '';
        this._addressForm.querySelector('[name="address[state]"]').value = data && data.uf || '';
    }
}

class Cart {
    constructor(selector) {
        this._selector = selector;
        this._el = document.querySelector(this._selector);

        document.addEventListener('address.changed', (evt) => {
            this.update({ zipcode: evt.detail.zipcode });
        });

        document.addEventListener('change', (evt) => {
            if (evt.target.name === 'shipping_method') {
                this.update({ shipping_method: evt.target.value });
            }
        });
    }

    async update(data) {
        const formData = new FormData();
        formData.append('_method', 'put');

        for (const key in data) {
            formData.append(key, data[key]);
        }

        const { data: html } = await axios.post('/cart', formData);

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // replaceChildren maintains reference to this._el
        const newElement = doc.querySelector(this._selector);
        this._el.replaceChildren(...newElement.children);
    }
}

const cart = new Cart('.js-cart-table');
const address = new Address('.js-addresses');
