<?php

namespace App\Checkout;

use App\Models\Order;
use Exception;

class CreditCardMethod implements PaymentMethod
{
    public function process(Order $order)
    {
        throw new Exception("Failed processing payment");
    }

    public function getName(): string
    {
        return 'credit_card';
    }

    public function getTemplate(): string
    {
        return 'payment/credit_card';
    }
}
