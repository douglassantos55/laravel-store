<?php

namespace App\Cart;

abstract class Voucher
{
    /**
     * @var string
     */
    public $ticker;

    public function __construct(string $ticker)
    {
        $this->ticker = $ticker;
    }

    public abstract function getDiscount(float $value): float;
}
