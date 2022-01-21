@extends('template/base')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="mb-4 text-2xl font-bold">{{ __('user.hello', ['name' => $user->name]) }}</h1>

    @foreach ($user->orders as $order)
    <div class="p-4 shadow-md">
        <div class="flex justify-between">
            <span class="font-semibold">{{ $order->id }}</span>
            <span class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>

        {{ $order->payment_method }}
        {{ $order->delivery_method }}
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
            <tr>
                <td colspan="3" class="font-bold text-right">Total</td>
                <td class="text-right font-bold">{{ $order->total }}</td>
            </tr>
        </table>
    </div>
    @endforeach
</div>
@endsection
