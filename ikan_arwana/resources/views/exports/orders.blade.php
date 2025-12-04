<table>
    <thead>
        <tr>
            <th>Order Number</th>
            <th>Date</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
            <td>{{ $order->customer_address }}</td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->payment_method }}</td>
            <td>{{ $order->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
