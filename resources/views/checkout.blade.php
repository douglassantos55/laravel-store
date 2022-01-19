@extends('template.base')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('checkout.title') }}</h1>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.personal_info') }}</h2>
                @include('checkout/customer')
            </div>

            <div>
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.delivery_info') }}</h2>
                @include('checkout/address')
            </div>

            <div>
                <h2 class="font-bold text-xl mb-4">{{ __('checkout.payment_info') }}</h2>

                @foreach ($methods as $paymentMethod)
                <div>
                    <input id="checkout-method-{{ $paymentMethod->getName() }}" type="radio" name="payment_method" value="{{ $paymentMethod->getName() }}" />
                    <label for="checkout-method-{{ $paymentMethod->getName() }}">{{ $paymentMethod->getName() }}</label>
                </div>

                @include($paymentMethod->getTemplate())
                @endforeach

                <div class="block mt-4">
                    <x-button primary type="submit" class="w-full">{{ __('checkout.finish') }}</x-button>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection
