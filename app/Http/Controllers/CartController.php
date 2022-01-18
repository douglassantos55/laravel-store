<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Cart\VoucherFactory;
use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @var Cart
     */
    public $cart;

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

        $this->cart->save();

        return redirect(route('cart.details'));
    }

    public function voucher(Request $request)
    {
        $voucher = $request->post('voucher');

        if (empty($voucher) || !in_array($voucher, ['bova11', 'ivvb11'])) {
            $request->session()->flash('cart_flash', 'Voucher is invalid');
            return back();
        }

        if ($voucher === 'bova11') {
            $this->cart->voucher = VoucherFactory::create($voucher, 'fixed');
        } else {
            $this->cart->voucher = VoucherFactory::create($voucher, 'percent');
        }

        $this->cart->save();
        return back();
    }
}
