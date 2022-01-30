<?php

namespace App\Cart\Shipping;

class MelhorEnvioShippingRate implements ShippingRate
{
    /**
     * @var array
     */
    private $rate;

    public function __construct(array $rate)
    {
        $this->rate = $rate;
    }

    public function getName(): string
    {
        return $this->rate['name'];
    }

    public function getPrice(): float
    {
        return $this->rate['price'];
    }

    public function getEstimate(): string
    {
        return $this->rate['delivery_time'];
    }

    public function getCompanyName(): string
    {
        return $this->rate['company']['name'];
    }

    public function getCompanyLogo(): string
    {
        return $this->rate['company']['picture'];
    }

    public function serialize()
    {
        return serialize($this->rate);
    }

    public function unserialize(string $data)
    {
        $this->rate = unserialize($data);
    }
}
