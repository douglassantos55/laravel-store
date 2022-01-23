@props(['book'])

<div class="shadow-lg hover:scale-105">
    <img src="http://placeimg.com/400/600/any" alt="Product image" class="w-full h-60 object-cover" />
    <div class="p-4">
        <h2 class="text-blue-600 text-xl font-bold">
            <a href="{{ route('book.details', ['book' => $book->id]) }}">{{ $book->title }}</a>
        </h2>

        <p>
            <span class="text-sm">by</span>
            <a href="{{ route('author.details', ['author' => $book->author->id]) }}" class="font-medium text-red-700 hover:underline">{{ $book->author->name }}</a>
        </p>

        <p class="text-gray-500 text-sm">
            <a href="{{ route('category.details', ['category' => $book->category->id]) }}" class="hover:underline">{{ $book->category->name }}</a>
            &bullet;
            <a href="{{ route('publisher.details', ['publisher' => $book->publisher->id]) }}" class="hover:underline">{{ $book->publisher->name }}</a>
        </p>

        <span class="block text-red-700 font-bold mt-2">{{ $book->price }}</span>

        <form method="POST" action="{{ route('cart.add') }}">
            @csrf

            <input type="hidden" name="book_id" value="{{ $book->id }}" />
            <x-button primary type="submit">{{ __('cart.add') }}</x-button>
        </form>

        <form method="POST" action="{{ route('wishlist.add') }}">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}" />
            <x-button secondary type="submit">{{ __('wishlist.add') }}</x-button>
        </form>
    </div>
</div>
