<?php

namespace App\Cart;

use App\Models\Book;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Cart {
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Collection
     */
    public $items;

    public function __construct(Session $session) {
        $this->session = $session;
        $this->load();
    }

    private function load() {
        $data = $this->session->get('cart');
        $this->items = $data->items;

        $this->items = $this->items->keyBy(function ($item) {
            return $item->getId();
        });
    }

    public function save() {
        $this->session->put('cart', $this);
    }

    public function add(Book $book, int $qty): Cart {
        $item = $this->items->get($book->id);

        if (!is_null($item)) {
            $item->incrementQty($qty);
        } else {
            $this->items->push(new CartItem($book, $qty));

        }

        return $this;
    }

    public function update(string $key, int $qty): Cart {
        $item = $this->items->get($key);

        if (!is_null($item)) {
            $item->updateQty($qty);
        }

        return $this;
    }

    public function count(): int {
        return $this->items->count();
    }
}
