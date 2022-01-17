<?php

namespace App\Cart;

use App\Models\Book;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Session\Session;

class Cart
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Collection
     */
    public $items;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->load();
    }

    public function load()
    {
        $items = $this->session->get('cart', []);
        $this->items = collect($items);
    }

    public function save()
    {
        $this->session->put('cart', $this->items->all());
        $this->session->save();
    }

    public function add(Book $book, int $qty): Cart
    {
        $item = $this->items->get($book->id);

        if (!is_null($item)) {
            $item->incrementQty($qty);
        } else {
            $this->items->push(new CartItem($book, $qty));

            $this->items = $this->items->keyBy(function ($item) {
                return $item->getId();
            });
        }

        return $this;
    }

    public function update(string $key, int $qty): Cart
    {
        $item = $this->items->get($key);

        if (!is_null($item)) {
            $item->updateQty($qty);
        }

        return $this;
    }

    public function remove(string $key): CartItem | null
    {
        if ($this->items->has($key)) {
            return $this->items->pull($key);
        }

        return null;
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function getTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->getSubtotal();
        });
    }
}
