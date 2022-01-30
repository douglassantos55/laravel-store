@if ($customer && !old('address.number'))
    @foreach ($customer->addresses as $address)
        <div class="mb-3 js-address-item">
            <input id="address-{{ $address->id }}" type="radio" name="address_id" value="{{ $address->id }}" {{ old('address_id') === $address->id ? 'checked' : '' }} data-zipcode="{{ $address->zipcode }}" />
            <label for="address-{{ $address->id }}">{{ $address }}</label>
        </div>
    @endforeach

    @error('address_id')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror

    <x-button secondary class="js-new-address">{{ __('checkout.new_address') }}</x-button>
@endif

<div class="{{ !$customer || old('address.number') ? '' : 'hidden' }}">
    <x-form-group>
        <label for="checkout-zipcode">{{ __('checkout.zipcode') }}</label>
        <x-input id="checkout-zipcode" type="text" name="address[zipcode]" value="{{ old('address.zipcode') }}" />

        @error('address.zipcode')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-street">{{ __('checkout.street') }}</label>
        <x-input id="checkout-street" type="text" name="address[street]" value="{{ old('address.street') }}" />

        @error('address.street')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-number">{{ __('checkout.number') }}</label>
        <x-input id="checkout-number" type="text" name="address[number]" value="{{ old('address.number') }}" />

        @error('address.number')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-complement">{{ __('checkout.complement') }}</label>
        <x-input id="checkout-complement" type="text" name="address[complement]" value="{{ old('address.complement') }}" />

        @error('address.complement')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-neighborhood">{{ __('checkout.neighborhood') }}</label>
        <x-input id="checkout-neighborhood" type="text" name="address[neighborhood]" value="{{ old('address.neighborhood') }}" />

        @error('address.neighborhood')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-city">{{ __('checkout.city') }}</label>
        <x-input id="checkout-city" type="text" name="address[city]" value="{{ old('address.city') }}" />

        @error('address.city')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="checkout-state">{{ __('checkout.state') }}</label>
        <x-input id="checkout-state" type="text" name="address[state]" value="{{ old('address.state') }}" />

        @error('address.state')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    @if ($customer)
        <x-button secondary class="js-use-address">{{ __('checkout.use_address') }}</x-button>
    @endif
</div>
