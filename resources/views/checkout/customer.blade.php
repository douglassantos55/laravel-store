<div class="mb-3">
    <label for="checkout-name">{{ __('checkout.name') }}</label>
    <input id="checkout-name" type="text" class="border p-2 block w-full" name="customer[name]" value="{{ old('customer.name') }}">

    @error('customer.name')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="checkout-email">{{ __('checkout.email') }}</label>
    <input id="checkout-email" type="email" class="border p-2 block w-full" name="customer[email]" value="{{ old('customer.email') }}">

    @error('customer.email')
        <div class="mt-1 text-red-600">{{ $message }}</div>
    @enderror
</div>
