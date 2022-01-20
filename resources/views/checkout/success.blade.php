@extends('template/base')

@section('title', __('checkout.order_placed'))

@section('content')
    <h1>{{ __('checkout.order_placed') }}</h1>
    <p>{{ $order->id }}</p>
@endsection
