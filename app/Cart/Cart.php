<?php

namespace App\Cart;

use App\Cart\Shipping\Shipment;
use App\Cart\Shipping\ShippingCalculator;
use App\Models\Book;
use App\Models\Voucher;
use Illuminate\Support\Collection;
use App\Cart\Shipping\ShippingRate;
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

    /**
     * @var string
     */
    public $shippingZipcode;

    /**
     * @var string
     */
    public $shippingMethod;

    /**
     * @var ShippingRate[]
     */
    public $shippingRates;


    /**
     * @var ShippingCalculator
     */
    private $shippingCalculator;

    public function __construct(Session $session, ShippingCalculator $shippingCalculator)
    {
        $this->session = $session;
        $this->load();
        $this->shippingCalculator = $shippingCalculator;
    }

    public function load()
    {
        $this->voucher = $this->session->get('cart.voucher', null);
        $this->items = collect($this->session->get('cart.items', []));
        $this->shippingMethod = $this->session->get('cart.shipping.method');
        $this->shippingRates = $this->session->get('cart.shipping.rates', []);
        $this->shippingZipcode = $this->session->get('cart.shipping.zipcode');
    }

    public function save()
    {
        $this->session->put('cart.items', $this->items->all());
        $this->session->put('cart.voucher', $this->voucher);
        $this->session->put('cart.shipping.zipcode', $this->shippingZipcode);
        $this->session->put('cart.shipping.rates', $this->shippingRates);
        $this->session->put('cart.shipping.method', $this->shippingMethod);

        $this->session->save();
    }

    public function setShippingZipcode(string $zipcode)
    {
        if (!empty($zipcode)) {
            $this->shippingZipcode = $zipcode;
            $this->calculateShipping($zipcode);
        }
    }

    public function calculateShipping(string $zipcode)
    {
        $shipment = new Shipment($this->items->all(), $zipcode);
        $this->shippingRates = $this->shippingCalculator->calculate($shipment);
        $this->save();
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

        if (!empty($this->shippingZipcode)) {
            $this->calculateShipping($this->shippingZipcode);
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

    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    public function getItems()
    {
        return $this->items->all();
    }

    public function clear()
    {
        $this->voucher = null;
        $this->items = collect([]);
        $this->shippingRates = [];
        $this->shippingZipcode = null;

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
        return $this->getSubtotal() + $this->getShippingPrice() - $this->getDiscount();
    }

    public function getDiscount(): float
    {
        if (is_null($this->voucher)) {
            return 0.0;
        }

        return $this->voucher->getDiscount($this->getSubtotal());
    }

    public function getShippingRate(): ?ShippingRate
    {
        if (empty($this->shippingMethod)) {
            return null;
        }

        $filtered = array_filter($this->shippingRates, function ($rate) {
            return $rate->getName() === $this->shippingMethod;
        });

        if (count($filtered) === 0) {
            return null;
        }

        return reset($filtered);
    }

    public function getShippingPrice(): float
    {
        $rate = $this->getShippingRate();

        if (!is_null($rate)) {
            return $rate->getPrice();
        }

        return 0;
    }
}
