<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('user.wishlist', ['books' => $user->wishlist]);
    }

    public function add(Request $request)
    {
        /**
         * @var User
         */
        $user = auth()->user();

        if (!$user->wishlist()->find($request->post('book_id'))) {
            $user->wishlist()->attach($request->post('book_id'));
        }

        return redirect(route('wishlist.index'));
    }

    public function remove(Request $request)
    {
        /**
         * @var User
         */
        $user = auth()->user();

        if ($user->wishlist()->find($request->post('book_id'))) {
            $user->wishlist()->detach($request->post('book_id'));
        }

        return redirect(route('wishlist.index'));
    }
}
