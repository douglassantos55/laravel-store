<?php

namespace App\Cart\Shipping;

class Shipment
{
    /**
     * @var Shippable[]
     */
    private $items;

    /**
     * @var string
     */
    private $destination;

    /**
     * @param Shippable[] $items
     * @param string $destination
     */
    public function __construct(array $items, string $destination)
    {
        $this->destination = $destination;
        $this->items = $items;
    }

    /**
     * @return Shippable[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }
}
