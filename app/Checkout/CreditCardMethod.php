<?php

namespace App\Checkout;

use App\Models\Order;

class CreditCardMethod implements PaymentMethod
{
    public function process(Order $order)
    {
        $order->status = Order::STATUS_PAID;
    }

    public function getName(): string
    {
        return 'credit_card';
    }

    public function getTemplate(): string
    {
        return 'payment/credit_card';
    }

    public function cancel(Order $order)
    {

    }
}
