@extends('template/base')

@section('title', $title)

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">{{ $title }}</h1>

    <div class="grid grid-cols-4 gap-8">
        <div class="shadow-lg hover:scale-105">
            <img src="http://placeimg.com/400/600/any" alt="Product image" class="w-full h-60 object-cover" />
            <div class="p-4">
                <h2 class="text-blue-600 text-xl font-bold">Product name</h2>
                <span class="block text-red-700 font-bold">R$ 2300,00</span>
                <x-button primary>{{ __('cart.add') }}</x-button>
                <x-button href="{{ route('welcome') }}" secondary>{{ __('wishlist.add') }}</x-button>
            </div>
        </div>

        <div class="shadow-lg hover:scale-105">
            <img src="http://placeimg.com/400/600/any" alt="Product image" class="w-full h-60 object-cover" />
            <div class="p-4">
                <h2 class="text-blue-600 text-xl font-bold">Product name</h2>
                <span class="block text-red-700 font-bold">R$ 2300,00</span>
                <x-button href="#" primary>{{ __('cart.add') }}</x-button>
                <x-button href="#" secondary>{{ __('wishlist.add') }}</x-button>
            </div>
        </div>
    </div>
</div>
@endsection
