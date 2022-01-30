<?php

namespace App\Cart\Shipping;

interface ShippingMethod
{
    public function getId(): string;
    public function getName(): string;

    /**
     * @param Shippable[]
     * @param string $destination
     *
     * @return ShippingRate[]
     */
    public function getRates(array $products, string $destination): array;
}
