@extends('template/base')

@section('title', $book->title)

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">{{ $book->title }}</h1>
    <p class="mt-2">
        <span class="text-sm">by</span>
        <a href="#" class="font-medium text-red-700 hover:underline">{{ $book->author->name }}</a>

        &bullet;

        <a href="#" class="hover:underline">{{ $book->category->name }}</a>
    </p>

    <p class="mt-6 text-gray-800">{{ $book->excerpt }}</p>

    <div class="flex items-center gap-4 mt-4">
        <p class="text-red-700 text-2xl font-bold">{{ $book->price }}</p>
        <x-button primary>{{ __('cart.add') }}</x-button>
        <x-button secondary>{{ __('wishlist.add') }}</x-button>
    </div>

    <ul class="mt-12">
        <li>Publisher: <a href="#" class="text-blue-600 hover:underline">{{ $book->publisher->name }}</a></li>
        <li>Edition: {{ $book->edition }}</li>
        <li>Pages: {{ $book->pages }}</li>
        <li>ISBN: {{ $book->isbn }}</li>
        <li>Language: {{ $book->language }}</li>
    </ul>
</div>
@endsection
