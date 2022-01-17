@extends('template/base')

@section('title', __('cart.title'))

@section('content')
<div class="container mx-auto">
    {{ app('session')->pull('cart_flash') }}

    <h1 class="text-4xl font-bold">{{ __('cart.title') }}</h1>

    <form method="POST">
        @csrf
        @method('PUT')

        <table class="w-full mt-10">
            <thead>
                <tr>
                    <th class="text-left">{{ __('cart.qty') }}</th>
                    <th class="text-left">{{ __('cart.product') }}</th>
                    <th class="text-right">{{ __('cart.price') }}</th>
                    <th class="text-right">{{ __('cart.subtotal') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($cart->items->all() as $item)
                <tr>
                    <td>
                        <input class="w-16" type="number" min="1" value="{{ $item->getQty() }}" name="items[{{ $item->getId() }}][qty]" />
                    </td>
                    <td>{{ $item->getProduct() }}</td>
                    <td class="text-right">{{ $item->getPrice() }}</td>
                    <td class="text-right">{{ $item->getSubtotal() }}</td>
                    <td class="text-right">
                        <x-button secondary type="submit" name="REMOVE" value="{{ $item->getId() }}">{{ __('cart.remove') }}</x-button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <x-button primary type="submit">{{ __('cart.update') }}</x-button>
    </form>
</div>
@endsection
