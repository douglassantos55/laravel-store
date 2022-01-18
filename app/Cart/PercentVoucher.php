<?php

namespace App\Cart;

class PercentVoucher extends Voucher {
    public function getDiscount(float $value): float
    {
        return $value * 0.1;
    }
}
