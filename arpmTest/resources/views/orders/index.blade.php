@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Items Count</th>
                <th>Last Added to Cart</th>
                <th>Completed?</th>
                <th>Created At</th>
                <th>Completed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order['order_id'] }}</td>
                    <td>{{ $order['customer_name'] }}</td>
                    <td>{{ $order['total_amount'] }}</td>
                    <td>{{ $order['items_count'] }}</td>
                    <td>{{ $order['last_added_to_cart'] }}</td>
                    <td>{{ $order['completed_order_exists'] ? 'Yes' : 'No' }}</td>
                    <td>{{ $order['created_at'] }}</td>
                    <td>{{ $order['completed_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
