document.querySelector('.js-new-address').addEventListener('click', function (evt) {
    evt.target.classList.add('hidden');
    evt.target.nextElementSibling.classList.remove('hidden');

    document.querySelectorAll('.js-address-item').forEach(function (item) {
        item.querySelector('input').checked = false;
        item.classList.add('hidden');
    });
});

document.querySelector('.js-use-address').addEventListener('click', function (evt) {
    evt.target.parentElement.classList.add('hidden');
    document.querySelector('.js-new-address').classList.remove('hidden');

    document.querySelectorAll('.js-address-item').forEach(function (item) {
        item.classList.remove('hidden');
    });
});
