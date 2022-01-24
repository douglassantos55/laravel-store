<div class="mt-2">
    <x-form-group>
        <label for="credit-card-number">{{ __('credit_card.number') }}</label>
        <x-input id="credit-card-number" type="text" name="credit_card[number]" />
    </x-form-group>

    <x-form-group>
        <label for="credit-card-name">{{ __('credit_card.name') }}</label>
        <x-input id="credit-card-name" type="text" name="credit_card[name]" />
    </x-form-group>

    <x-form-group>
        <label for="credit-card-cvv">{{ __('credit_card.cvv') }}</label>
        <x-input id="credit-card-cvv" type="text" name="credit_card[cvv]" />
    </x-form-group>


    <x-form-group>
        <label for="credit-card-expiration-date">{{ __('credit_card.expiration_date') }}</label>
        <x-input id="credit-card-expiration-date" type="text" name="credit_card[expiration_date]" />
    </x-form-group>
</div>
