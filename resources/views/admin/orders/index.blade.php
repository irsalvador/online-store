@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order List</h1>
        @if (!empty($orders) && $orders->count() > 0)
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Details</th>
                    <th>Total Price</th>
                    <th>Shipped?</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr class="{{ $order->shipped === 1 ? 'table-success' : ''}} {{ $order->cancelled === 1 ? 'table-danger' : ''}}">
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            <table class="table table-bordered {{ $order->shipped === 1 ? 'table-success' : ''}} {{ $order->cancelled === 1 ? 'table-danger' : ''}}">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                </tr>
                                </thead>
                            @foreach(unserialize($order->order_details) as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ $item['price'] }}</td>
                                </tr>
                            @endforeach
                            </table>
                        </td>
                        <td>${{ $order->total_amount }}</td>
                        <th>{{ ($order->shipped === 0 ? 'No' : 'Yes') }}</th>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            @if ($order->shipped === 0 && $order->cancelled === 0)
                                <button onclick="markAsShipped({{ $order->id }})" class="btn btn-outline-success btn-sm">Mark as Shipped</button>
                                <button onclick="cancelOrder({{ $order->id }})" class="btn btn-outline-danger btn-sm">Cancel Order</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No orders found.</p>
        @endif

        <script>
            function markAsShipped(orderId){
                fetch('{{ route('admin.orders.markAsShipped') }}', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                    }),
                }).then(response => response.json())
                    .then(data => {
                        location.reload();
                    });
            }

            function cancelOrder(orderId) {
                if (confirm('Are you sure you want to cancel this order ' + orderId + '?') === true){
                    fetch('{{ route('admin.orders.cancel') }}', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                        }),
                    }).then(response => response.json())
                        .then(data => {
                            location.reload();
                        });
                }
            }
        </script>
    </div>
@endsection
