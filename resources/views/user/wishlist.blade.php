@extends('template.base')

@section('title', __('user.wishlist'))

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ __('user.wishlist') }}</h1>

    <div class="grid grid-cols-4 gap-8">
        @foreach ($books as $book)
            <x-book :book="$book" />
        @endforeach
    </div>
</div>
@endsection
