const newAddress = document.querySelector('.js-new-address');

if (newAddress) {
    newAddress.addEventListener('click', function (evt) {
        evt.target.classList.add('hidden');
        evt.target.nextElementSibling.classList.remove('hidden');

        document.querySelectorAll('.js-address-item').forEach(function (item) {
            item.querySelector('input').checked = false;
            item.classList.add('hidden');
        });
    });
}

const useAddress = document.querySelector('.js-use-address');

if (useAddress) {
    useAddress.addEventListener('click', function (evt) {
        evt.target.parentElement.classList.add('hidden');
        document.querySelector('.js-new-address').classList.remove('hidden');

        document.querySelectorAll('.js-address-item').forEach(function (item) {
            item.classList.remove('hidden');
        });
    });
}

document.querySelectorAll('[name="shipping_method"]').forEach(function (item) {
    item.addEventListener('change', function (evt) {
        console.log(evt.target.value);
        updateCart({ shipping_method: evt.target.value })
    });
});

document.querySelectorAll('[name="address_id"]').forEach(function (item) {
    item.addEventListener('change', function (evt) {
        updateCart({ zipcode: evt.target.dataset.zipcode });
    });
});

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
