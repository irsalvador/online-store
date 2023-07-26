@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>
        @if(empty($cart))
            <p>Your cart is empty.</p>
        @else
            <ul>
                @foreach($cart as $productId => $quantity)
                    <li>Product ID: {{ $productId }} | Quantity: {{ $quantity }}</li>
                @endforeach
            </ul>
            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Checkout</a>
        @endif
    </div>
@endsection
