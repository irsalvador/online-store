@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('home') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search products by name or description" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <h1>Product List</h1>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-6 mb-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title" id="title-{{ $product->id }}">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text">Price: ${{ $product->price }}</p>
                            <button class="btn btn-primary" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $products->appends(request()->query())->links() }}

        <a href="{{ route('cart.view') }}" class="btn btn-primary mt-3">View Cart</a>
    </div>

    <script>
        function addToCart(productId) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    product_id: productId,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    const cardTitleElement = document.querySelector('#title-' + productId);

                    const newDivElement = document.createElement('div');

                    newDivElement.textContent = data.message;
                    newDivElement.style.padding = "10px";
                    newDivElement.classList.add('fade-out');
                    newDivElement.classList.add('alert');
                    newDivElement.classList.add('alert-success');

                    cardTitleElement.parentNode.insertBefore(newDivElement, cardTitleElement);

                    setTimeout(() => {
                        newDivElement.classList.remove('fade-out');
                        newDivElement.remove();
                    }, 500);
                });
        }
    </script>

    <style>
        .fade-out {
            animation: fadeOutAnimation 2s ease;
        }

        @keyframes fadeOutAnimation {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
@endsection
