<?php

namespace App\Cart;

class Voucher
{
    /**
     * @var string
     */
    public $ticker;

    public function __construct(string $ticker)
    {
        $this->ticker = $ticker;
    }

    public function getDiscount(): float
    {
        return $this->ticker == 'bova11' ? 10.0 : 20.0;
    }
}
