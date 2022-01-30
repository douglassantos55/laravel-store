<?php

namespace App\Cart\Shipping;

use Serializable;

interface ShippingRate extends Serializable
{
    public function getName(): string;
    public function getPrice(): float;
    public function getEstimate(): string;
    public function getCompanyName(): string;
    public function getCompanyLogo(): string;
}
