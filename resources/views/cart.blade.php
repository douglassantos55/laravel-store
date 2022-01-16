@extends('template/base')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold">Shopping Cart</h1>

    <form method="POST">
        @csrf
        @method('PUT')

        <table class="w-full mt-10">
            <thead>
                <tr>
                    <th class="text-left">Qty</th>
                    <th class="text-left">Product</th>
                    <th class="text-left">Price</th>
                    <th class="text-left">Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart->items->all() as $item)
                <tr>
                    <td>
                        <input class="w-16" type="number" min="1" value="{{ $item->getQty() }}" name="items[{{ $item->getId() }}][qty]" />
                    </td>
                    <td>{{ $item->getProduct() }}</td>
                    <td>{{ $item->getPrice() }}</td>
                    <td>{{ $item->getSubtotal() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <x-button primary type="submit">{{ __('cart.update') }}</x-button>
    </form>
</div>
@endsection
