<?php

namespace App\Cart\Shipping;

class ShippingCalculator
{
    private $shippingMethods;

    public function __construct(ShippingMethod ...$shippingMethods)
    {
        $this->shippingMethods = $shippingMethods;
    }

    /**
     * Calculates shipping rates for each registered shipping method
     *
     * @param Shipment $shipment
     *
     * @return ShippingRate[]
     */
    public function calculate(Shipment $shipment)
    {
        $rates = [];

        foreach ($this->shippingMethods as $method) {
            $rates = array_merge(
                $rates,
                $method->getRates($shipment->getItems(), $shipment->getDestination())
            );
        }

        return $rates;
    }
}
