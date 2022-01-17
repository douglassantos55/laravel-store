<?php

use App\Cart\Cart;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $books = Book::with(['author', 'category', 'publisher'])->get();
    return view('welcome', ['title' => 'Welcome to the Store', 'books' => $books]);
})->name('welcome');

Route::get('/book/{book}', function (Book $book) {
    return view('book', ['book' => $book]);
})->name('book.details');

Route::get('/author/{author}', function (Author $author) {
    return view('author', ['author' => $author]);
})->name('author.details');

Route::get('/category/{category}', function (Category $category) {
    return view('category', ['category' => $category]);
})->name('category.details');

Route::get('/publisher/{publisher}', function (Publisher $publisher) {
    return view('publisher', ['publisher' => $publisher]);
})->name('publisher.details');

Route::post('/cart', function (Request $request, Cart $cart) {
    $book = Book::find($request->post('book_id'));
    $cart->add($book, 1)->save();

    session()->flash('cart_flash', 'Item added to cart');
    return redirect(route('cart.details'));
})->name('cart.add');

Route::put('/cart', function (Request $request, Cart $cart) {
    if ($request->has('REMOVE')) {
        $removed = $cart->remove($request->post('REMOVE'));

        if (!is_null($removed)) {
            session()->flash('cart_flash', "Item \"{$removed->getProduct()}\" removed");
        }
    } else if ($request->has('items')) {
        foreach ($request->post('items') as $key => $item) {
            $cart->update($key, $item['qty']);
        }

        session()->flash('cart_flash', 'Items updated');
    }

    $cart->save();
    return redirect(route('cart.details'));
})->name('cart.update');

Route::get('/cart', function (Cart $cart) {
    return view('cart', ['cart' => $cart]);
})->name('cart.details');
