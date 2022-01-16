@props(['book'])

<div class="shadow-lg hover:scale-105">
    <img src="http://placeimg.com/400/600/any" alt="Product image" class="w-full h-60 object-cover" />
    <div class="p-4">
        <h2 class="text-blue-600 text-xl font-bold">
            <a href="{{ route('book.details', ['book' => $book->id]) }}">{{ $book->title }}</a>
        </h2>

        <p>
            <span class="text-sm">by</span>
            <a href="#" class="font-medium text-red-700 hover:underline">{{ $book->author->name }}</a>
        </p>

        <p class="text-gray-500 text-sm">
            <a href="#" class="hover:underline">{{ $book->category->name }}</a>
            &bullet;
            <a href="#" class="hover:underline">{{ $book->publisher->name }}</a>
        </p>

        <span class="block text-red-700 font-bold mt-2">{{ $book->price }}</span>

        <x-button primary>{{ __('cart.add') }}</x-button>
        <x-button href="{{ route('welcome') }}" secondary>{{ __('wishlist.add') }}</x-button>
    </div>
</div>
