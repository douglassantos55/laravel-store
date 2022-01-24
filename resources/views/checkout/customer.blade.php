<x-form-group>
    <label for="checkout-name">{{ __('checkout.name') }}</label>
    <x-input id="checkout-name" type="text" name="customer[name]" value="{{ old('customer.name', $customer ? $customer->name : '') }}" />

    @error('customer.name')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror
</x-form-group>

<x-form-group>
    <label for="checkout-email">{{ __('checkout.email') }}</label>
    <x-input id="checkout-email" type="email" name="customer[email]" value="{{ old('customer.email', $customer ? $customer->email : '') }}" />

    @error('customer.email')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror
</x-form-group>
