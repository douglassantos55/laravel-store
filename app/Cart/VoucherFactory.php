<?php

namespace App\Cart;

abstract class VoucherFactory
{
    const FIXED = 'fixed';
    const PERCENT = 'percent';

    public static function create(string $ticker, string $type): Voucher
    {
        switch ($type) {
            case self::FIXED:
                return new FixedVoucher($ticker);
                break;
            case self::PERCENT:
                return new PercentVoucher($ticker);
                break;
        }
    }
}
