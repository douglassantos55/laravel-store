@if ($customer && !old('address.number'))
    @foreach ($customer->addresses as $address)
        <div class="mb-3 js-address-item">
            <input id="address-{{ $address->id }}" type="radio" name="address_id" value="{{ $address->id }}" {{ old('address_id') === $address->id ? 'checked' : '' }}/>
            <label for="address-{{ $address->id }}">{{ $address }}</label>
        </div>
    @endforeach

    @error('address_id')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror

    <x-button secondary class="js-new-address">{{ __('user.new_address') }}</x-button>
@endif

<div class="{{ !$customer || old('address.number') ? '' : 'hidden' }}">
    <div class="mb-3">
        <label for="checkout-zipcode">{{ __('checkout.zipcode') }}</label>
        <input id="checkout-zipcode" type="text" class="border p-2 block w-full" name="address[zipcode]" value="{{ old('address.zipcode') }}">

        @error('address.zipcode')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-street">{{ __('checkout.street') }}</label>
        <input id="checkout-street" type="text" class="border p-2 block w-full" name="address[street]" value="{{ old('address.street') }}">

        @error('address.street')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-number">{{ __('checkout.number') }}</label>
        <input id="checkout-number" type="text" class="border p-2 block w-full" name="address[number]" value="{{ old('address.number') }}">

        @error('address.number')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-complement">{{ __('checkout.complement') }}</label>
        <input id="checkout-complement" type="text" class="border p-2 block w-full" name="address[complement]" value="{{ old('address.complement') }}">

        @error('address.complement')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-neighborhood">{{ __('checkout.neighborhood') }}</label>
        <input id="checkout-neighborhood" type="text" class="border p-2 block w-full" name="address[neighborhood]" value="{{ old('address.neighborhood') }}">

        @error('address.neighborhood')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-city">{{ __('checkout.city') }}</label>
        <input id="checkout-city" type="text" class="border p-2 block w-full" name="address[city]" value="{{ old('address.city') }}">

        @error('address.city')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="checkout-state">{{ __('checkout.state') }}</label>
        <input id="checkout-state" type="text" class="border p-2 block w-full" name="address[state]" value="{{ old('address.state') }}">

        @error('address.state')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </div>

    @if ($customer)
        <x-button secondary class="js-use-address">{{ __('user.use_address') }}</x-button>
    @endif
</div>
