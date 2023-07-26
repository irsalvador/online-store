<!-- resources/views/customer/cart/view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <h1>View Cart</h1>
        @if (!empty($cart) && count($cart) > 0)
            <div class="row mb-3">
                <div class="col">Product ID</div>
                <div class="col">Product Name</div>
                <div class="col">Quantity</div>
                <div class="col">Unit Price</div>
                <div class="col">Action</div>
            </div>
            <hr>
            @foreach ($cart as $productId => $item)
                <div class="row">
                    <div class="col">{{ $productId }}</div>
                    <div class="col">{{ $item['name'] }}</div>
                    <div class="col">{{ $item['quantity'] }}</div>
                    <div class="col">${{ number_format($item['price'], 2, '.', ',') }}</div>
                    <div class="col"><a onclick="removeItem({{ $productId }})" class="btn btn-outline-danger">Remove</a></div>
                </div>
                <hr>
            @endforeach
            <div class="row">
                <div class="col"><strong>Total Price: ${{ number_format($total_price, 2, '.', ',') }}</strong></div>
            </div>
            <hr>

            <a onclick="checkoutCart()" class="btn btn-success">Checkout</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Add more products</a>
            <a onclick="clearCart()" class="btn btn-danger">Clear Cart</a>
        @else
            <p>Your cart is empty.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Add products to cart</a>
        @endif

        <script>
            function clearCart(){
                fetch('{{ route('cart.clear') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                    }).then(response => response.json())
                    .then(data => {
                        location.reload();
                    });
            }

            function removeItem(productId){
                fetch('{{ route('cart.item.clear') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                    }),
                }).then(response => response.json())
                    .then(data => {
                        location.reload();
                    });
            }

            function checkoutCart(){
                fetch('{{ route('cart.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                }).then(response => response.json())
                    .then(data => {
                        location.reload();
                    });
            }
        </script>
    </div>
@endsection
