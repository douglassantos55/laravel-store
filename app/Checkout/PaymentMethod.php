<?php

namespace App\Checkout;

use App\Models\Order;

interface PaymentMethod
{
    public function getName(): string;
    public function cancel(Order $order);
    public function getTemplate(): string;
    public function process(Order $order, array $data);
}
