@extends('template.base')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('checkout.title') }}</h1>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.personal_info') }}</h2>
                @include('checkout/customer', ['customer' => $customer])

                <h2 class="font-bold text-xl mt-8 mb-4">{{ __('checkout.delivery_info') }}</h2>
                @include('checkout/address', ['zipcode' => $cart->shippingZipcode, 'customer' => $customer])
            </div>

            <div>
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.payment_info') }}</h2>

                @foreach ($methods as $paymentMethod)
                <div>
                    <input id="checkout-method-{{ $paymentMethod->getName() }}" type="radio" name="payment_method" value="{{ $paymentMethod->getName() }}" {{ old('payment_method') == $paymentMethod->getName() ? "checked" : "" }} />
                    <label for="checkout-method-{{ $paymentMethod->getName() }}">{{ $paymentMethod->getName() }}</label>
                </div>

                <div class="">
                    @include($paymentMethod->getTemplate())
                </div>
                @endforeach

                @error('payment_method')
                <div class="mt-1 text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="js-cart-table">
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.order') }}</h2>

                <table class="w-full mt-4">
                    <tbody>
                        @foreach ($cart->getItems() as $item)

                        <tr>
                            <td>{{ $item->getProduct() }}</td>
                            <td class="text-right">{{ $item->getQty() }}x</td>
                            <td class="text-right">{{ $item->getPrice() }}</td>
                            <td class="text-right">{{ $item->getSubtotal() }}</td>
                        </tr>
                        @endforeach

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
                            <td colspan="3" class="text-right font-bold">
                                {{ __('cart.voucher') }}
                                <span class="text-blue-600">{{ $cart->voucher->code }}</span>
                            </td>
                            <td class="text-right font-bold">-{{ $cart->getDiscount() }}</td>
                        </tr>
                        @endif

                        <tr>
                            <td class="font-bold text-right" colspan="3">{{ __('cart.total') }}</td>
                            <td class="font-bold text-right">{{ $cart->getTotal() }}</td>
                        </tr>
                    </tbody>
                </table>

                <x-shipping-methods :cart="$cart" />

                <div class="block mt-4">
                    <x-button primary type="submit" class="w-full">{{ __('checkout.finish') }}</x-button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script src="{{ mix('js/checkout/checkout.js') }}"></script>
@endpush
