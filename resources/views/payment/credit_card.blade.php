<div class="mt-2">
    <x-form-group>
        <label for="credit-card-number">{{ __('credit_card.number') }}</label>
        <x-input id="credit-card-number" type="text" name="credit_card[number]" value="{{ old('credit_card.number') }}" />

        @error('credit_card.number')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="credit-card-name">{{ __('credit_card.name') }}</label>
        <x-input id="credit-card-name" type="text" name="credit_card[name]" value="{{ old('credit_card.name') }}" />

        @error('credit_card.name')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>

    <x-form-group>
        <label for="credit-card-cvv">{{ __('credit_card.cvv') }}</label>
        <x-input id="credit-card-cvv" type="text" name="credit_card[cvv]" value="{{ old('credit_card.cvv') }}" />

        @error('credit_card.cvv')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>


    <x-form-group>
        <label for="credit-card-expiration-date">{{ __('credit_card.expiration_date') }}</label>
        <x-input id="credit-card-expiration-date" type="text" name="credit_card[expiration_date]" value="{{ old('credit_card.expiration_date') }}" />

        @error('credit_card.expiration_date')
            <div class="mt-1 text-red-600">{{ $message }}</div>
        @enderror
    </x-form-group>
</div>
