<?php

namespace App\Cart\Shipping;

interface Shippable
{
    public function getQty(): int;
    public function getId(): string;
    public function getPrice(): float;
    public function getWidth(): float;
    public function getHeight(): float;
    public function getLength(): float;
    public function getWeight(): float;
}
