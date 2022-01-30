@props(['cart'])

<div>
    @foreach ($cart->shippingRates as $rate)
        <x-form-group class="flex items-center">
            <input type="radio" name="shipping_method" value="{{ $rate->getName() }}" id="shipping-{{ $rate->getName() }}" {{ $rate === $cart->getShippingRate() ? 'checked' : '' }}>

            <label for="shipping-{{ $rate->getName() }}" class="ml-2">
                <img class="w-20 mb-1" src="{{ $rate->getCompanyLogo() }}" alt="{{ $rate->getCompanyName() }}" />
                {{ $rate->getName() }} - {{ $rate->getPrice() }} - {{ trans_choice('cart.estimate', $rate->getEstimate(), ['value' => $rate->getEstimate()]) }}</p>
            </label>
        </x-form-group>
    @endforeach
</div>
