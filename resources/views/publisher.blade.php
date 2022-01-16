@extends('template/base')

@section('title', $publisher->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">{{ $publisher->name }}</h1>

    <div class="grid grid-cols-4 gap-8">
        @foreach ($publisher->books as $book)
            <x-book :book="$book" />
        @endforeach
    </div>
</div>
@endsection
