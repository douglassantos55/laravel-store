<?php

namespace App\Cart;

use App\Models\Book;

class CartItem {
    /**
     * @var int
     */
    public $qty;

    /**
     * @var Book
     */
    public $book;

    public function __construct(Book $book, int $qty) {
        $this->qty = $qty;
        $this->book = $book;
    }

    public function getId(): string {
        return $this->book->id;
    }

    public function getQty(): int {
        return $this->qty;
    }

    public function getSubtotal(): float {
        return $this->book->price * $this->qty;
    }

    public function getProduct(): string {
        return $this->book->title;
    }

    public function getPrice(): float {
        return $this->book->price;
    }

    public function incrementQty(int $qty) {
        $this->updateQty($this->qty + $qty);
    }

    public function updateQty(int $qty) {
        $this->qty = $qty;
    }
}
