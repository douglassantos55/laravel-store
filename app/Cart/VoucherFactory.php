<?php

namespace App\Cart;

use App\Models\Voucher;

abstract class VoucherFactory
{
    public static function create(string $ticker, string $type): Voucher
    {
        switch ($type) {
            case Voucher::TYPE_FIXED:
                return new FixedVoucher($ticker);
                break;
            case Voucher::TYPE_PERCENT:
                return new PercentVoucher($ticker);
                break;
        }
    }
}
