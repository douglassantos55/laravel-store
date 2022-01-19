<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Voucher;
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

Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'details'])->name('cart.details');
Route::put('/cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/voucher', [CartController::class, 'voucher'])->name('cart.voucher');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
