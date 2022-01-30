<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Cart\Shipping\ShippingMethod;
use App\Models\Book;
use App\Models\Voucher;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;

        $this->middleware(function ($request, $next) {
            $this->cart->load();
            return $next($request);
        });
    }

    public function details()
    {
        return view('cart', ['cart' => $this->cart]);
    }

    public function add(Request $request)
    {
        $book = Book::find($request->post('book_id'));
        $this->cart->add($book, 1)->save();

        return back();
    }

    public function update(Request $request)
    {
        if ($request->has('REMOVE')) {
            $this->cart->remove($request->post('REMOVE'));
        } else if ($request->has('items')) {
            foreach ($request->post('items') as $key => $item) {
                $this->cart->update($key, $item['qty']);
            }
        }

        if ($request->post('zipcode')) {
            $this->cart->setShippingZipcode($request->post('zipcode'));
        }

        if ($request->post('shipping_method')) {
            $this->cart->shippingMethod = $request->post('shipping_method');
        }

        $this->cart->save();

        if ($request->ajax()) {
            return redirect(route('checkout'));
        }

        return redirect(route('cart.details'));
    }

    public function voucher(Request $request)
    {
        $code = $request->post('voucher');
        $voucher = Voucher::where('code', $code)->first();

        if (empty($voucher) || !$voucher->isValid()) {
            $this->cart->voucher = null;
            $this->cart->save();
            $request->session()->flash('cart_flash', 'Voucher not found');

            return back();
        }

        $this->cart->voucher = $voucher;
        $this->cart->save();

        return back();
    }
}
