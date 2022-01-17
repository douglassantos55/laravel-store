<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
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

    public function details() {
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
}
