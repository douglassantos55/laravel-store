<?php

namespace App\Cart;

use App\Models\Book;
use App\Models\Voucher;
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

    /**
     * @var Voucher
     */
    public $voucher;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->load();
    }

    public function load()
    {
        $this->items = collect($this->session->get('cart.items', []));
        $this->voucher = $this->session->get('cart.voucher', null);
    }

    public function save()
    {
        $this->session->put('cart.items', $this->items->all());
        $this->session->put('cart.voucher', $this->voucher);

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

    public function empty()
    {
        $this->voucher = null;
        $this->items = collect([]);

        $this->save();
    }

    public function getSubtotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item->getSubtotal();
        });
    }

    public function getTotal(): float
    {
        return $this->getSubtotal() - $this->getDiscount();
    }

    public function getDiscount(): float
    {
        if (is_null($this->voucher)) {
            return 0.0;
        }

        return $this->voucher->getDiscount($this->getSubtotal());
    }
}
