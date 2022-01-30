<?php

namespace App\Cart;

use App\Models\Book;
use App\Cart\Shipping\Shippable;

class CartItem implements Shippable
{
    /**
     * @var int
     */
    public $qty;

    /**
     * @var Book
     */
    public $book;

    public function __construct(Book $book, int $qty)
    {
        $this->qty = $qty;
        $this->book = $book;
    }

    public function getId(): string
    {
        return $this->book->id;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function getSubtotal(): float
    {
        return $this->book->price * $this->qty;
    }

    public function getProduct(): string
    {
        return $this->book->title;
    }

    public function getPrice(): float
    {
        return $this->book->price;
    }

    public function incrementQty(int $qty)
    {
        $this->updateQty($this->qty + $qty);
    }

    public function updateQty(int $qty)
    {
        $this->qty = $qty;
    }

    public function getWeight(): float
    {
        return 0.6;
    }

    public function getWidth(): float
    {
        return 20;
    }

    public function getHeight(): float
    {
        return 30;
    }

    public function getLength(): float
    {
        return 0.3;
    }
}
