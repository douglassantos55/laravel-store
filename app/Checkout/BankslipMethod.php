<?php

namespace App\Checkout;

use App\Models\Order;

class BankslipMethod implements PaymentMethod
{
    public function process(Order $order)
    {

    }

    public function getName(): string
    {
        return 'bankslip';
    }

    public function getTemplate(): string
    {
        return 'payment/bankslip';
    }
}
