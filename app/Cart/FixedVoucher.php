<?php

namespace App\Cart;

class FixedVoucher extends Voucher {
    public function getDiscount(float $value): float
    {
        return 10.0;
    }
}
