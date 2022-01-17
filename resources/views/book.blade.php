@extends('template/base')

@section('title', $book->title)

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">{{ $book->title }}</h1>

    <p class="mt-2">
        <span class="text-sm">by</span>
        <a href="{{ route('author.details', ['author' => $book->author->id]) }}" class="font-medium text-red-700 hover:underline">{{ $book->author->name }}</a>
        &bullet;
        <a href="{{ route('category.details', ['category' => $book->category->id]) }}" class="hover:underline">{{ $book->category->name }}</a>
    </p>

    <p class="mt-6 text-gray-800">{{ $book->excerpt }}</p>

    <div class="flex items-center gap-4 mt-4">
        <p class="text-red-700 text-2xl font-bold">{{ $book->price }}</p>

        <form method="POST" action="{{ route('cart.add') }}">
            @csrf

            <input type="hidden" name="book_id" value="{{ $book->id }}" />
            <x-button primary type="submit">{{ __('cart.add') }}</x-button>
            <x-button secondary>{{ __('wishlist.add') }}</x-button>
        </form>
    </div>

    <ul class="mt-12">
        <li>Publisher: <a href="{{ route('publisher.details', ['publisher' => $book->publisher->id]) }}" class="text-blue-600 hover:underline">{{ $book->publisher->name }}</a></li>
        <li>Edition: {{ $book->edition }}</li>
        <li>Pages: {{ $book->pages }}</li>
        <li>ISBN: {{ $book->isbn }}</li>
        <li>Language: {{ $book->language }}</li>
    </ul>
</div>
@endsection
