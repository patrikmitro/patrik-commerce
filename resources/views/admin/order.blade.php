<h1>Order ID: {{ $order->id }}</h1>

<table>
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Created At</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Country</th>
        <th>Order Date</th>
        <th>Address</th>
        <th>City</th>
        <th>Zip</th>
        <th>Phone</th>
        <th>email</th>
        <th>Order Notes</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->first_name }}</td>
            <td>{{ $order->last_name }}</td>
            <td>{{ $order->country }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->city }}</td>
            <td>{{ $order->zip }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->email }}</td>
            <td>
                <textarea>
                    {{ $order->order_notes }}
                </textarea>
            </td>
        </tr>

    </tbody>
</table>

<h1>Products</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Order Notes</th>
        <th>Total</th>
        <th>Order Date</th>
    </tr>
    </thead>
    @foreach($order->products as $product)

    <tbody>
    <tr>
        <td>{{ $product->uuid }}</td>
        <td>{{ $product->title }}</td>
        <td>${{ $order->price }}</td>
        <td>{{ $product->pivot->quantity }}</td>
        <td>${{ $order->price }}</td>
        <td>{{ $order->total }}</td>
        <td>{{ $product->created_at }}</td>

    </tr>
    </tbody>
    @endforeach
</table>
