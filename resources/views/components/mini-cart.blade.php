<div class="group relative">
    <p>Cart <span class="text-sm font-medium inline-flex items-center justify-center w-4 h-4 rounded-full bg-blue-600 text-white">{{ $cart->count() }}</p>

    <div class="hidden group-hover:block w-64 bg-white shadow-lg p-4 absolute right-0 border">
        <span class="font-medium text-xl">{{ __('cart.title') }}</span>

        @if ($cart->count() > 0)
            <table class="w-full mt-4">
                <tbody>
                    @foreach ($cart->items->all() as $item)

                    <tr>
                        <td>{{ $item->getProduct() }}</td>
                        <td class="text-right">{{ $item->getSubtotal() }}</td>
                        <td class="text-right">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <x-button secondary type="submit" name="REMOVE" value="{{ $item->getId() }}">X</x-button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td class="font-bold">{{ __('cart.total') }}</td>
                        <td class="font-bold text-right">{{ $cart->getTotal() }}</td>
                    </tr>
                </tbody>
            </table>

            <x-button primary class="w-full text-center mt-4" href="{{ route('cart.details') }}">
                {{ __('cart.goto') }}
            </x-button>
        @else
            <p class="mt-3">{{ __('cart.empty') }}</p>
        @endif
    </div>
</div>
