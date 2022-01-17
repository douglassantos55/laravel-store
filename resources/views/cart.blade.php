@extends('template/base')

@section('title', __('cart.title'))

@section('content')
<div class="container mx-auto">
    {{ app('session')->pull('cart_flash') }}

    <h1 class="text-4xl font-bold">{{ __('cart.title') }}</h1>

    @if ($cart->count() > 0)
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
                        <input class="border py-1 px-2 w-16" type="number" min="1" value="{{ $item->getQty() }}" name="items[{{ $item->getId() }}][qty]" />
                    </td>
                    <td>{{ $item->getProduct() }}</td>
                    <td class="text-right">{{ $item->getPrice() }}</td>
                    <td class="text-right">{{ $item->getSubtotal() }}</td>
                    <td class="text-right">
                        <x-button secondary type="submit" name="REMOVE" value="{{ $item->getId() }}">{{ __('cart.remove') }}</x-button>
                    </td>
                </tr>
                @endforeach
                <tr class="text-lg">
                    <td colspan="3" class="text-right font-bold">Total</td>
                    <td class="text-right font-bold">{{ $cart->getTotal() }}</td>
                </tr>
            </tbody>
        </table>

        <x-button primary type="submit">{{ __('cart.update') }}</x-button>
    </form>

    <h2 class="font-semibold text-xl">{{ __('cart.voucher') }}</h2>

    <div class="flex items-center mt-4 gap-2">
        <input class="border p-2" placeholder="{{ __('cart.voucher') }}" />
        <x-button secondary>{{ __('cart.apply_voucher') }}</x-button>
    </div>
    @else
    <p class="mt-8">{{ __('cart.empty') }}</p>
    @endif
</div>
@endsection
