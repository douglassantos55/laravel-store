@extends('template/base')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between">
        {{ $order->id }}
        <span class="text-sm text-gray-600">
            @if ($order->isPending())
            <a class="text-red-600 mr-4" href="{{ route('checkout.cancel', ['order' => $order->id]) }}">Cancel order</a>
            @endif

            {{ $order->created_at->format('d/m/Y H:i') }}
        </span>
    </div>

    {{ $order->payment_method }}
    {{ $order->status }}

    <table class="w-full mt-4">
        @foreach ($order->items as $item)
        <tr>
            <td>{{ $item->book->title }}</td>
            <td class="text-right">{{ $item->qty }}x</td>
            <td class="text-right">{{ $item->price }}</td>
            <td class="text-right">{{ $item->subtotal }}</td>
        </tr>
        @endforeach

        @if ($order->voucher)
        <tr>
            <td colspan="3" class="text-right font-semibold text-blue-600">{{ $order->voucher->code }}</td>
            <td class="text-right">-{{ $order->discount }}</td>
        </tr>
        @endif

        @if ($order->shipping_method)
        <tr>
            <td colspan="3" class="text-right font-semibold text-blue-600">
                <img src="{{ $order->shipping_company_logo }}" class="w-20 inline" />
                {{ $order->shipping_service }}
            </td>
            <td class="text-right">{{ $order->shipping_cost }}</td>
        </tr>
        @endif
        <tr>
            <td colspan="3" class="font-bold text-right">Total</td>
            <td class="text-right font-bold">{{ $order->total }}</td>
        </tr>
    </table>

    <h3 class="mb-4 text-xl font-semibold">{{ __('user.invoices') }}</h3>

    @foreach ($order->invoices as $invoice)
    <div class="p-4 shadow-md">
        <div class="flex justify-between">
            {{ $invoice->id }}
CC: {{ $invoice->credit_card_number }}

            <div>
                <span class="text-sm text-gray-600">
                    {{ $invoice->status }} &bullet;
                    <a href="{{ $invoice->invoice_url }}" class="text-blue-600 hover:underline" target="_blank">See invoice</a>
                    {{ __('invoice.due_date') }} {{ $invoice->due_date->format('d/m/Y') }} &bullet;
                    {{ __('invoice.created_at') }} {{ $invoice->created_at->format('d/m/Y H:i') }}
                </span>
            </div>
        </div>

        <p>{{ __('invoice.total') }} {{ $invoice->total }}</p>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/order/details.js') }}"></script>
@endpush
