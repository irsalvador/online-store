@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('admin.products.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search products by name or description" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header">{{ __('Product List') }}</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($products as $product)
                                <div class="col-md-6 mb-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ $product->description }}</p>
                                            <p class="card-text">Price: ${{ $product->price }}</p>

                                            @if (auth()->user()->user_type === 'admin')
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Update</a>
                                                <a href="{{ route('products.destroy-confirm', $product->id) }}" class="btn btn-danger">Delete</a>
                                            @else
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Add to Cart</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
