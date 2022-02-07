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

        <table class="js-cart w-full mt-10">
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
                @foreach ($cart->getItems() as $item)
                <tr>
                    <td>
                        <x-input type="number" min="1" value="{{ $item->getQty() }}" name="items[{{ $item->getId() }}][qty]" />
                    </td>
                    <td>{{ $item->getProduct() }}</td>
                    <td class="text-right">{{ $item->getPrice() }}</td>
                    <td class="text-right">{{ $item->getSubtotal() }}</td>
                    <td class="text-right">
                        <x-button secondary type="submit" name="REMOVE" value="{{ $item->getId() }}">{{ __('cart.remove') }}</x-button>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right font-bold">{{ __('cart.subtotal') }}</td>
                    <td class="text-right font-bold">{{ $cart->getSubtotal() }}</td>
                </tr>
                @if ($cart->getShippingRate())
                <tr>
                    <td colspan="3" class="text-right font-bold">
                        {{ __('cart.shipping') }}
                        <span class="text-blue-600">{{ $cart->getShippingRate()->getName() }}</span>
                    </td>
                    <td class="text-right font-bold">{{ $cart->getShippingPrice() }}</td>
                </tr>
                @endif
                @if ($cart->voucher)
                <tr>
                    <td colspan="3" class="text-right font-bold">{{ __('cart.voucher') }} <span class="text-blue-600">{{ $cart->voucher->code }}</span></td>
                    <td class="text-right font-bold">-{{ $cart->getDiscount() }}</td>
                </tr>
                @endif
                <tr class="text-lg">
                    <td colspan="3" class="text-right font-bold">Total</td>
                    <td class="text-right font-bold">{{ $cart->getTotal() }}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="text-xl font-semibold">{{ __('cart.shipping') }}</h3>

        <div class="flex mb-5">
            <x-input name="zipcode" class="w-auto" value="{{ $cart->shippingZipcode }}" />
            <x-button secondary type="submit">{{ __('cart.calculate') }}</x-button>
        </div>

        <x-shipping-methods :cart="$cart" />

        <x-button secondary type="submit">{{ __('cart.update') }}</x-button>

        <x-button primary href="{{ route('checkout') }}">{{ __('cart.checkout') }}</x-button>
    </form>

    <h2 class="font-semibold text-xl mt-5">{{ __('cart.voucher') }}</h2>

    <form action="{{ route('cart.voucher') }}" method="POST">
        @csrf
        <div class="flex items-center mt-4 gap-2">
            <x-input placeholder="{{ __('cart.voucher') }}" name="voucher" />
            <x-button secondary type="submit">{{ __('cart.apply_voucher') }}</x-button>
        </div>
    </form>
    @else
    <p class="mt-8">{{ __('cart.empty') }}</p>
    @endif
</div>
@endsection

@stack('scripts')
<script src="{{ mix('js/checkout/cart.js') }}"></script>
@endstack
