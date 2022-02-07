import Echo from '../echo'

'use strict'

console.log('order/details.js');

Echo.private('App.Models.User.1')
    .notification(function (evt) {
        if (evt.type === 'App\\Notifications\\OrderStatusChanged') {
            if (confirm('Order status change, refresh page?')) {
                window.location.reload();
            }
        }
    });
