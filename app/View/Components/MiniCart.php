<?php

namespace App\View\Components;

use App\Cart\Cart;
use Illuminate\View\Component;

class MiniCart extends Component
{
    /**
     * @var Cart
     */
    public $cart;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.mini-cart');
    }
}
