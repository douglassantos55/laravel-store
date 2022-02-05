import './bootstrap';

const newAddress = document.querySelector('.js-new-address');

if (newAddress) {
    newAddress.addEventListener('click', function (evt) {
        document.querySelector('.js-address').classList.remove('hidden');
        document.querySelector('.js-existing-address').classList.add('hidden');

        document.querySelectorAll('.js-address-item').forEach(function (item) {
            item.querySelector('input').checked = false;
        });
    });
}

const useAddress = document.querySelector('.js-use-address');

if (useAddress) {
    useAddress.addEventListener('click', function (evt) {
        document.querySelector('.js-address').classList.add('hidden');
        document.querySelector('.js-existing-address').classList.remove('hidden');
    });
}

const zipcode = document.querySelector('[name="address[zipcode]"]');

if (zipcode) {
    zipcode.addEventListener('blur', async function (evt) {
        const response = await fetch(`https://viacep.com.br/ws/${evt.target.value}/json/`)
        const data = await response.json();

        if (data.erro) {
            updateAddress();
        } else {
            updateAddress(data);
            document.querySelector('[name="address[number]"]').focus();
        }

        updateCart({ zipcode: evt.target.value })
    });

    zipcode.dispatchEvent(new FocusEvent('blur'));
}

document.addEventListener('change', function (evt) {
    if (evt.target.name === 'shipping_method') {
        updateCart({ shipping_method: evt.target.value })
    }

    if (evt.target.name === 'address_id') {
        updateCart({ zipcode: evt.target.dataset.zipcode });
    }
});

function updateAddress(data) {
    document.querySelector('[name="address[street]"]').value = data && data.logradouro || '';
    document.querySelector('[name="address[complement]"]').value = data && data.complemento || '';
    document.querySelector('[name="address[neighborhood]"]').value = data && data.bairro || '';
    document.querySelector('[name="address[city]"]').value = data && data.localidade || '';
    document.querySelector('[name="address[state]"]').value = data && data.uf || '';
}

async function updateCart(data) {
    const formData = new FormData();
    formData.append('_method', 'put');

    for (const key in data) {
        formData.append(key, data[key]);
    }

    const response = await fetch('/cart', {
        method: 'POST',
        headers: {
            'x-requested-with': 'XMLHttpRequest',
        },
        mode: 'cors',
        body: formData
    });

    const parser = new DOMParser();
    const doc = parser.parseFromString(await response.text(), 'text/html');
    document.querySelector('.js-cart-table').replaceWith(doc.querySelector('.js-cart-table'));
}

window.Echo.private('App.Models.User.1')
    .notification(function (evt) {
        console.log(evt);
    });
