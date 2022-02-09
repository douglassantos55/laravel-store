<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\WishlistController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
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

Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');

Route::post('/auth/login', [LoginController::class, 'login'])->name('auth.login');
Route::get('/auth/login', [LoginController::class, 'index'])->name('auth.index');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware('auth');
Route::get('/dashboard/order/{order}', [UserController::class, 'order'])->name('user.order')->middleware('auth');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index')->middleware('auth');
Route::post('/wishlist', [WishlistController::class, 'add'])->name('wishlist.add')->middleware('auth');
Route::delete('/wishlist', [WishlistController::class, 'remove'])->name('wishlist.remove')->middleware('auth');

Route::post('/webhook/{processor}', [WebhookController::class, 'process']);
