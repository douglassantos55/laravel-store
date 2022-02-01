@extends('template/base')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <p>{{ app('session')->pull('dashboard') }}</p>

    <h1 class="mb-4 text-2xl font-bold">{{ __('user.hello', ['name' => $user->name]) }}</h1>

    @foreach ($user->orders as $order)
    <div class="p-4 shadow-md">
        <div class="flex justify-between">
            <a href="{{ route('user.order', ['order' => $order->id]) }}" class="font-semibold">{{ $order->id }}</a>
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
    </div>
    @endforeach
</div>
@endsection
